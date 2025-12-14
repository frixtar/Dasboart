<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('email', 'admin@sistema.com')->exists()) {
            
            User::create([
                'name' => 'Administrador Principal',
                'email' => 'admin@sistema.com',
                'password' => Hash::make('password123'),
                
                'role' => 'administrador', 
                'can_edit_products' => true,
                'can_delete_products' => true,
            ]);
            
            $this->command->info('¡Usuario Administrador creado exitosamente!');
        } else {
            $this->command->warn('El usuario administrador ya existe.');
        }
    }
}
