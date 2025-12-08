<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SaleProcessTest extends TestCase
{
    // Esta línea es MAGIA: Borra la BD y la crea de nuevo para cada prueba.
    // Así siempre pruebas en un entorno limpio.
    use RefreshDatabase;

    /**
     * Prueba: Un cajero puede realizar una venta exitosa y se descuenta el stock.
     */
    public function test_cashier_can_make_a_sale_and_stock_decreases()
    {
        // 1. PREPARACIÓN (Arrange)
        // Creamos un cajero falso
        $cajero = User::factory()->create([
            'role' => 'cajero',
            'name' => 'Pepito Test',
            'email' => 'cajero@test.com',
        ]);

        // Creamos un producto con 10 de stock
        $product = Product::factory()->create([
            'barcode' => 'TEST01',
            'price' => 100,
            'stock' => 10,
            'has_iva' => true,
        ]);

        // Simulamos el carrito de compras (lo que envía JavaScript)
        $cartPayload = [
            'cart' => [
                [
                    'id' => $product->id,
                    'quantity' => 2, // Vendemos 2
                    // Nota: El backend busca el precio real en BD, el del carrito es referencia
                ]
            ],
            'amount_paid' => 500,
            'change' => 300
        ];

        // 2. ACCIÓN (Act)
        // Actuamos como el cajero ($cajero) y enviamos una petición POST a /sales
        $response = $this->actingAs($cajero)
                         ->postJson(route('sales.store'), $cartPayload);

        // 3. AFIRMACIÓN (Assert)
        
        // A. Verificar que el servidor respondió "OK" (Código 200) y success: true
        $response->assertStatus(200)
                 ->assertJson(['success' => true]);

        // B. Verificar que se creó la venta en la base de datos
        $this->assertDatabaseHas('sales', [
            'user_id' => $cajero->id,
            'total' => 200, // 2 productos * 100 pesos
        ]);

        // C. Verificar que se creó el detalle de venta
        $this->assertDatabaseHas('sale_details', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        // D. VERIFICACIÓN CRÍTICA: ¿Bajó el stock?
        // Recargamos el producto fresco de la base de datos
        $product->refresh();
        
        // Tenía 10, vendimos 2, debe quedar en 8.
        $this->assertEquals(8, $product->stock);
    }

    /**
     * Prueba: No se puede vender si no hay stock.
     */
    public function test_cannot_sell_without_stock()
    {
        // Cajero
        $cajero = User::factory()->create(['role' => 'cajero']);

        // Producto con solo 1 en stock
        $product = Product::factory()->create(['stock' => 1]);

        // Intentamos vender 5
        $cartPayload = [
            'cart' => [
                ['id' => $product->id, 'quantity' => 5]
            ]
        ];

        // Acción
        $response = $this->actingAs($cajero)
                         ->postJson(route('sales.store'), $cartPayload);

        // Afirmación: Debe fallar (Error 400 o 500) y NO debe crear la venta
        $response->assertStatus(400); // Esperamos error controlado
        
        // El stock debe seguir intacto en 1
        $this->assertEquals(1, $product->fresh()->stock);
    }
}