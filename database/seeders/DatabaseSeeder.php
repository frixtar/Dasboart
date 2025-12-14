<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Aquí registramos el orden en que queremos crear los datos
        $this->call([
            AdminUserSeeder::class
        ]);
    }
}
