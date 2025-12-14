<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;
    public function test_admin_can_login_and_redirect_to_dashboard()
    {
        $admin = User::factory()->create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'role' => 'administrador', // <--- Clave
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'password123',
        ]);
        $this->assertAuthenticatedAs($admin);
        $response->assertRedirect(route('dashboard'));
    }
    public function test_admin_does_not_go_to_pos()
    {
         $admin = User::factory()->create([
            'role' => 'administrador',
            'password' => bcrypt('password'), // <--- Esto arregla el error de configuración
        ]);

        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('dashboard')); 
        $this->assertNotEquals(route('pos.index'), $response->headers->get('Location'));
    }
}