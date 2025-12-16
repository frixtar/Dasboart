<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_puede_crear_producto_con_datos_validos()
    {
        // 1. Crear Admin usando bcrypt explícito para evitar el error de hash
        $admin = User::factory()->create([
            'role' => 'administrador',
            'password' => bcrypt('password'), 
        ]);

        // Solución: Asignamos nombre explícito para evitar error NOT NULL
        $category = Category::factory()->create(['name' => 'Categoría General']);
        $supplier = Supplier::factory()->create(['name' => 'Proveedor Principal']);

        // 2. Datos válidos
        $validData = [
            'barcode' => '123456789012', 
            'name' => 'Producto Valido',
            'price' => 500.00,
            'stock' => 100,
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'expiration_date' => now()->addMonth()->format('Y-m-d'),
            'has_iva' => 'on',
        ];

        // 3. Actuar como el admin
        $response = $this->actingAs($admin)->post(route('products.store'), $validData);

        // 4. Verificar
        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('products', [
            'barcode' => '123456789012',
            'name' => 'Producto Valido'
        ]);
    }

    public function test_falla_si_el_codigo_de_barras_no_tiene_12_digitos()
    {
        $admin = User::factory()->create([
            'role' => 'administrador',
            'password' => bcrypt('password'),
        ]);

        // Solución: Nombre explícito
        $category = Category::factory()->create(['name' => 'Categoría Test']);

        $invalidData = [
            'barcode' => '123', // Error
            'name' => 'Prod Test',
            'category_id' => $category->id,
            'price' => 100,
            'stock' => 10,
            'expiration_date' => now()->addDay()->format('Y-m-d'),
        ];

        $response = $this->actingAs($admin)->post(route('products.store'), $invalidData);
        $response->assertSessionHasErrors(['barcode']);
    }

    public function test_falla_si_el_nombre_es_muy_largo()
    {
        $admin = User::factory()->create([
            'role' => 'administrador',
            'password' => bcrypt('password'),
        ]);
        
        // Solución: Nombre explícito
        $category = Category::factory()->create(['name' => 'Categoría Test']);

        $invalidData = [
            'barcode' => '123456789012',
            'name' => 'Este nombre es demasiado largo para el sistema', // Error > 20 chars
            'category_id' => $category->id,
            'price' => 100,
            'stock' => 10,
            'expiration_date' => now()->addDay()->format('Y-m-d'),
        ];

        $response = $this->actingAs($admin)->post(route('products.store'), $invalidData);
        $response->assertSessionHasErrors(['name']);
    }

    public function test_falla_si_la_fecha_de_caducidad_es_pasada()
    {
        $admin = User::factory()->create([
            'role' => 'administrador',
            'password' => bcrypt('password'),
        ]);
        
        // Solución: Nombre explícito
        $category = Category::factory()->create(['name' => 'Categoría Test']);

        $invalidData = [
            'barcode' => '123456789012',
            'name' => 'Leche',
            'category_id' => $category->id,
            'price' => 20,
            'stock' => 50,
            'expiration_date' => now()->subDay()->format('Y-m-d'), // Error: fecha pasada
        ];

        $response = $this->actingAs($admin)->post(route('products.store'), $invalidData);
        $response->assertSessionHasErrors(['expiration_date']);
    }

    public function test_usuario_sin_permisos_no_puede_eliminar_producto()
    {
        // Usuario normal (vendedor)
        $user = User::factory()->create([
            'role' => 'vendedor',
            'password' => bcrypt('password'),
            'can_delete_products' => false 
        ]);
        
        // Solución: Aseguramos que el producto se cree con una categoría válida
        $category = Category::factory()->create(['name' => 'Categoría Base']);
        $product = Product::factory()->create(['category_id' => $category->id]);

        $response = $this->actingAs($user)->delete(route('products.destroy', $product->id));
        $response->assertStatus(403);
        $this->assertDatabaseHas('products', ['id' => $product->id]);
    }

    public function test_admin_puede_eliminar_producto()
    {
        // Usuario Administrador
        $admin = User::factory()->create([
            'role' => 'administrador',
            'password' => bcrypt('password'),
        ]);
        
        // Solución: Aseguramos que el producto se cree con una categoría válida
        $category = Category::factory()->create(['name' => 'Categoría Base']);
        $product = Product::factory()->create(['category_id' => $category->id]);

        $response = $this->actingAs($admin)->delete(route('products.destroy', $product->id));

        $response->assertRedirect(route('products.index'));
        
        // CAMBIO: Usamos assertSoftDeleted porque el registro persiste en BD (SoftDeletes)
        // O verificamos que Eloquent ya no lo encuentra (lo cual cubre ambos casos)
        $this->assertNull(Product::find($product->id));
    }
}