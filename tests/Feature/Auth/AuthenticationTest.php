<?php

use App\Models\User;

test('login screen can be rendered', function () {
    $response = $this->get('/login');
    $response->assertStatus(200);
});

test('redirección de administradores a dashboard', function () {
    $user = User::factory()->create([
        'role' => 'administrador'
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard'));
});
    
test('redirección de cajeros a pos después de iniciar sesión', function () {
    $user = User::factory()->create([
        'role' => 'cajero'
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
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    // Al salir, normalmente mandamos al inicio (login)
    $response->assertRedirect('/'); 
});