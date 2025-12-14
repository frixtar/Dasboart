<?php

use App\Models\User;

test('login screen can be rendered', function () {
    $response = $this->get('/login');
    $response->assertStatus(200);
});

test('redirección de administradores a dashboard', function () {
    // CORRECCIÓN: Generamos password fresco
    $user = User::factory()->create([
        'role' => 'administrador',
        'password' => bcrypt('password'), 
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard'));
});
    
test('redirección de cajeros a pos después de iniciar sesión', function () {
    // CORRECCIÓN: Generamos password fresco
    $user = User::factory()->create([
        'role' => 'cajero',
        'password' => bcrypt('password'),
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    // Verificamos que aterrice en el POS
    $response->assertRedirect(route('pos.index'));
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create([
        'password' => bcrypt('password'),
    ]);

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create([
        'password' => bcrypt('password'),
    ]);

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    // CORRECCIÓN: Al salir, el sistema redirige al login (ya sea directo o por la ruta raíz)
    $response->assertRedirect('/login'); 
});