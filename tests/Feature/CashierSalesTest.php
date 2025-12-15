<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CashierSalesTest extends TestCase
{
    use RefreshDatabase;

    public function test_cashier_can_access_pos_screen()
    {
        $cajero = User::factory()->create([
            'role' => 'cajero',
            'password' => bcrypt('password')
        ]);

        $response = $this->actingAs($cajero)->get(route('pos.index'));

        $response->assertStatus(200);
        $response->assertViewIs('pos.index');
    }

    public function test_cashier_can_process_a_successful_sale()
    {
        $cajero = User::factory()->create([
            'role' => 'cajero',
            'password' => bcrypt('password')
        ]);

        $category = Category::create(['name' => 'General']);
        
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 50.00,
            'stock' => 10,
            'has_iva' => false
        ]);
        $saleData = [
            'cart' => [
                [
                    'id' => $product->id,
                    'quantity' => 2
                ]
            ],
            'amount_paid' => 200,
            'change' => 100
        ];

        // 3. Ejecutar la venta
        $response = $this->actingAs($cajero)
                         ->postJson(route('sales.store'), $saleData);

        // 4. Verificaciones
        $response->assertStatus(200)
                 ->assertJson(['success' => true]);

        // Verificar DB: Venta registrada
        $this->assertDatabaseHas('sales', [
            'user_id' => $cajero->id,
            'total' => 100,
            'amount_paid' => 200,
            'change' => 100,
        ]);

        // Verificar DB: Detalle registrado
        $this->assertDatabaseHas('sale_details', [
            'product_id' => $product->id,
            'quantity' => 2,
            'total_row' => 100,
        ]);

        // Verificar DB: Stock descontado (10 - 2 = 8)
        $this->assertEquals(8, $product->fresh()->stock);
    }
    public function test_cannot_sell_exceeding_stock()
    {
        $cajero = User::factory()->create(['role' => 'cajero', 'password' => bcrypt('password')]);
        $category = Category::create(['name' => 'General']);
        
        // Producto con solo 5 en existencia
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'stock' => 5
        ]);

        // Intentamos vender 10
        $saleData = [
            'cart' => [
                ['id' => $product->id, 'quantity' => 10]
            ],
            'amount_paid' => 500,
            'change' => 0
        ];

        $response = $this->actingAs($cajero)
                         ->postJson(route('sales.store'), $saleData);
        $response->assertStatus(400)
                 ->assertJson(['success' => false]);
        $this->assertEquals(5, $product->fresh()->stock);
    }
}