<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CashierManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Prueba 1: Un administrador puede crear un cajero válido.
     */
    public function test_admin_can_create_cashier()
    {
        // 1. Crear Admin
        $admin = User::factory()->create([
            'role' => 'administrador',
            'password' => bcrypt('password'),
        ]);

        // 2. Datos del nuevo cajero
        $cashierData = [
            'name' => 'Juan Perez', // Solo letras y espacios
            'email' => 'juan@caja.com',
            'email_confirmation' => 'juan@caja.com', // Confirmación requerida
            'password' => 'secret123', // Mínimo 8 caracteres
            'password_confirmation' => 'secret123',
        ];

        // 3. Enviar petición
        $response = $this->actingAs($admin)
                         ->post(route('cashiers.store'), $cashierData);

        // 4. Verificar
        $response->assertRedirect(route('cashiers.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'email' => 'juan@caja.com',
            'role' => 'cajero',
        ]);
    }

    /**
     * Prueba 2: Las validaciones estrictas de cajeros funcionan.
     */
    public function test_cashier_validations_prevent_bad_data()
    {
        $admin = User::factory()->create([
            'role' => 'administrador',
            'password' => bcrypt('password'),
        ]);

        // Intentamos enviar datos inválidos
        $badData = [
            'name' => 'Juan123', // Error: Tiene números
            'email' => 'bad-email', // Error: No es email
            'password' => '123', // Error: Muy corta
            'password_confirmation' => '123',
        ];

        $response = $this->actingAs($admin)
                         ->post(route('cashiers.store'), $badData);

        // Verificar que falle en los campos esperados
        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    /**
     * Prueba 3: Un administrador puede actualizar un cajero.
     */
    public function test_admin_can_update_cashier()
    {
        // CORREGIDO: Ambos usuarios deben tener password fresco para evitar el error de hash
        $admin = User::factory()->create([
            'role' => 'administrador', 
            'password' => bcrypt('password')
        ]);
        
        $cashier = User::factory()->create([
            'role' => 'cajero',
            'password' => bcrypt('password') // <--- ESTO FALTABA
        ]);

        $updateData = [
            'name' => 'Nuevo Nombre',
            'email' => 'nuevo@email.com',
            'password' => '', // Dejamos vacío para no cambiar contraseña
            'password_confirmation' => '',
        ];

        $response = $this->actingAs($admin)
                         ->put(route('cashiers.update', $cashier->id), $updateData);

        $response->assertRedirect(route('cashiers.index'));
        
        $this->assertDatabaseHas('users', [
            'id' => $cashier->id,
            'name' => 'Nuevo Nombre',
            'email' => 'nuevo@email.com',
        ]);
    }

    /**
     * Prueba 4: Un administrador puede eliminar un cajero.
     */
    public function test_admin_can_delete_cashier()
    {
        // CORREGIDO: Password fresco aquí también
        $admin = User::factory()->create([
            'role' => 'administrador', 
            'password' => bcrypt('password')
        ]);
        
        $cashier = User::factory()->create([
            'role' => 'cajero',
            'password' => bcrypt('password')
        ]);

        $response = $this->actingAs($admin)
                         ->delete(route('cashiers.destroy', $cashier->id));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('users', [
            'id' => $cashier->id
        ]);
    }
}