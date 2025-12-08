<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Productos Reales (Ejemplos Fijos para tus pruebas)
        $realProducts = [
            ['barcode' => '7501055310805', 'name' => 'Coca Cola 600ml', 'price' => 18.00, 'stock' => 50, 'has_iva' => true],
            ['barcode' => '7501000133039', 'name' => 'Pan Bimbo Blanco', 'price' => 42.50, 'stock' => 20, 'has_iva' => false],
            ['barcode' => '7501030490607', 'name' => 'Sabritas Sal 45g', 'price' => 17.00, 'stock' => 30, 'has_iva' => true],
            ['barcode' => '12345678', 'name' => 'Producto Prueba', 'price' => 100.00, 'stock' => 10, 'has_iva' => true],
            ['barcode' => '00000000', 'name' => 'Producto Agotado', 'price' => 50.00, 'stock' => 0, 'has_iva' => true],
        ];

        foreach ($realProducts as $prod) {
            // Usamos firstOrCreate para no duplicarlos si corres el seeder dos veces
            Product::firstOrCreate(['barcode' => $prod['barcode']], $prod);
        }

        // 2. Relleno Masivo (50 productos aleatorios extra)
        Product::factory(50)->create();
    }
}