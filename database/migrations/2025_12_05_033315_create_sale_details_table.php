<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('sales', function (Blueprint $table) {
        $table->id();
        // Relación con el cajero que hizo la venta
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
        
        $table->string('invoice_number')->unique(); // Folio del ticket
        $table->decimal('subtotal', 10, 2);
        $table->decimal('iva', 10, 2);
        $table->decimal('total', 10, 2);
        
        $table->timestamps(); // Fecha y hora de venta
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_details');
    }
};
