<?php

namespace Tests\Feature;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SupplierTest extends TestCase
{
    use RefreshDatabase;

    public function test_se_puede_crear_un_nuevo_proveedor()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $data = [
            'name' => 'Proveedor Test S.A.',
            'contact_name' => 'Roberto Gómez',
            'phone' => '5512345678',
            'email' => 'ventas@proveedor.com',
            'address' => 'Calle Falsa 123',
        ];

        $response = $this->actingAs($user)->post(route('suppliers.store'), $data);

        $response->assertRedirect(route('suppliers.index'));
        
        // Verificar base de datos
        $this->assertDatabaseHas('suppliers', [
            'name' => 'Proveedor Test S.A.',
            'email' => 'ventas@proveedor.com'
        ]);
    }

    public function test_se_puede_actualizar_un_proveedor()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        // Aquí ya se estaba asignando el nombre, por lo que debería funcionar bien
        $supplier = Supplier::factory()->create([
            'name' => 'Nombre Viejo'
        ]);

        $response = $this->actingAs($user)->put(route('suppliers.update', $supplier), [
            'name' => 'Nombre Nuevo',
            'contact_name' => 'Nuevo Contacto',
        ]);

        $response->assertRedirect(route('suppliers.index'));
        
        $this->assertDatabaseHas('suppliers', [
            'id' => $supplier->id,
            'name' => 'Nombre Nuevo'
        ]);
    }

    public function test_se_puede_eliminar_un_proveedor()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);
        
        // Corrección: Asignar 'name' explícitamente
        $supplier = Supplier::factory()->create([
            'name' => 'Proveedor a Eliminar'
        ]);

        $response = $this->actingAs($user)->delete(route('suppliers.destroy', $supplier));

        $response->assertRedirect(route('suppliers.index'));
        $this->assertDatabaseMissing('suppliers', ['id' => $supplier->id]);
    }
}