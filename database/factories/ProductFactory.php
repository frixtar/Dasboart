<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            // Genera un código de barras aleatorio de 13 dígitos
            'barcode' => $this->faker->unique()->numerify('#############'),
            
            // Genera nombres de productos de 2 o 3 palabras con sufijos comerciales
            'name' => ucfirst($this->faker->words(2, true)) . ' ' . $this->faker->randomElement(['500ml', '1kg', 'Grande', 'Pack 6', 'Clásico']),
            
            // Precio aleatorio entre 10 y 500 pesos (2 decimales)
            'price' => $this->faker->randomFloat(2, 10, 500),
            
            // Stock aleatorio entre 0 y 100
            'stock' => $this->faker->numberBetween(0, 100),
            
            // 80% de probabilidad de tener IVA
            'has_iva' => $this->faker->boolean(80),
        ];
    }
}