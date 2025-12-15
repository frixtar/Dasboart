<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Lista de categorías reales
        $categories = [
            'Abarrotes',
            'Bebidas y Licores',
            'Frutas y Verduras',
            'Carnes y Embutidos',
            'Lácteos y Derivados',
            'Panadería y Dulces',
            'Higiene Personal',
            'Limpieza del Hogar',
            'Mascotas',
            'Farmacia',
            'Electrónica y Hogar'
        ];

        foreach ($categories as $name) {
            Category::firstOrCreate([
                'name' => $name
            ], [
                'description' => 'Productos pertenecientes a la sección de ' . $name
            ]);
        }
    }
}