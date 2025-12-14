<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('barcode')->unique();
        $table->string('name');
        $table->decimal('price', 10, 2); // Precio de venta
        $table->date('expiration_date')->nullable(); // Fecha de caducidad
        $table->foreignId('category_id')
              ->nullable()
              ->constrained('categories')
              ->nullOnDelete(); 
        $table->integer('stock');
        $table->boolean('has_iva')->default(true);
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['category', 'expiration_date']);
        });
    }
};
