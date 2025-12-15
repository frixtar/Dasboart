<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        // 1. Intentar obtener una categoría existente al azar
        $category = Category::inRandomOrder()->first();

        // Si no hay categorías (por si borraste la tabla), crear una de emergencia
        if (!$category) {
            $category = Category::create([
                'name' => 'General', 
                'description' => 'Categoría por defecto'
            ]);
        }

        return [
            // Código de barras de 12 dígitos (750 es el prefijo común en México)
            'barcode' => $this->faker->unique()->numerify('750#########'),
            
            // Nombre comercial realista
            'name' => ucfirst($this->faker->word) . ' ' . 
                      $this->faker->randomElement(['Clásico', 'Premium', 'Supremo', 'Fresco', 'Oferta']) . ' ' . 
                      $this->faker->randomElement(['250g', '500ml', '1kg', '1L', 'Pack 6']),
            
            // Relación con categoría
            'category_id' => $category->id,
            
            // Precio entre $10 y $1,500
            'price' => $this->faker->randomFloat(2, 10, 1500),
            
            // Stock (algunos en 0 para probar alertas)
            'stock' => $this->faker->numberBetween(0, 150),
            
            // Fechas variadas (algunas vencidas, otras futuras)
            'expiration_date' => $this->faker->dateTimeBetween('-1 month', '+2 years')->format('Y-m-d'),
            
            // 80% de probabilidad de tener IVA
            'has_iva' => $this->faker->boolean(80),
        ];
    }
}