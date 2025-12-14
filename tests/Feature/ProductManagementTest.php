<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Prueba 1: Un administrador puede crear un producto con Categoría y Caducidad.
     */
    public function test_admin_can_create_product_with_full_details()
    {
        // 1. Crear Admin y Categoría (CORREGIDO: Password fresco)
        $admin = User::factory()->create([
            'role' => 'administrador',
            'password' => bcrypt('password'), 
        ]);
        
        $category = Category::create(['name' => 'Lácteos']);

        // 2. Datos del formulario
        $productData = [
            'barcode' => '123456789012', // 12 dígitos exactos
            'name' => 'Leche Entera',
            'category_id' => $category->id,
            'price' => 25.50,
            'stock' => 100,
            'expiration_date' => Carbon::tomorrow()->format('Y-m-d'), // Fecha futura
            'has_iva' => true,
        ];

        // 3. Enviar petición POST
        $response = $this->actingAs($admin)
                         ->post(route('products.store'), $productData);

        // 4. Verificar
        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('products', [
            'barcode' => '123456789012',
            'category_id' => $category->id,
            // CORREGIDO: Ajustamos el formato para coincidir con lo que guarda la BD (con hora 00:00:00)
            'expiration_date' => Carbon::tomorrow()->format('Y-m-d 00:00:00'),
        ]);
    }

    /**
     * Prueba 2: Las validaciones estrictas bloquean datos incorrectos.
     */
    public function test_product_validations_prevent_bad_data()
    {
        // CORREGIDO: Password fresco
        $admin = User::factory()->create([
            'role' => 'administrador',
            'password' => bcrypt('password'),
        ]);

        // Intentamos enviar basura
        $badData = [
            'barcode' => '123', // Muy corto
            'name' => 'A', // Muy corto
            'price' => -10, // Negativo
            'stock' => 10.5, // Decimal (debe ser entero)
            'expiration_date' => Carbon::yesterday()->format('Y-m-d'), // Fecha pasada
        ];

        $response = $this->actingAs($admin)
                         ->post(route('products.store'), $badData);

        // Debe fallar y regresar errores en estos campos
        $response->assertSessionHasErrors(['barcode', 'name', 'price', 'stock', 'expiration_date']);
    }

    /**
     * Prueba 3 (CRÍTICA): El Borrado Suave funciona incluso con ventas históricas.
     */
    public function test_soft_delete_works_on_sold_products()
    {
        // 1. Preparar escenario (CORREGIDO: Password fresco)
        $admin = User::factory()->create([
            'role' => 'administrador',
            'password' => bcrypt('password'),
        ]);
        
        $product = Product::factory()->create(); // Crea producto
        
        // Simular que este producto YA SE VENDIÓ (Crear historial)
        $sale = Sale::create([
            'user_id' => $admin->id,
            'invoice_number' => 'T-001',
            'subtotal' => 86.21,
            'iva' => 13.79,
            'total' => 100
        ]);
        
        SaleDetail::create([
            'sale_id' => $sale->id,
            'product_id' => $product->id, // Aquí está la relación foránea
            'quantity' => 1,
            'price' => 100,
            'total_row' => 100
        ]);

        // 2. Intentar borrar el producto
        $response = $this->actingAs($admin)
                         ->delete(route('products.destroy', $product->id));

        // 3. Verificaciones
        // No debe dar Error 500 de SQL
        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('success');

        // El producto debe estar "Soft Deleted" (existe en BD, pero con deleted_at lleno)
        $this->assertSoftDeleted('products', [
            'id' => $product->id
        ]);

        // La venta debe seguir existiendo (Integridad histórica)
        $this->assertDatabaseHas('sale_details', [
            'product_id' => $product->id
        ]);
    }
}