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
    Schema::table('users', function (Blueprint $table) {
        // 'admin' o 'cajero'
        $table->string('role')->default('cajero'); 
        
        // Permisos específicos (booleans son perfectos para SQLite y lógica simple)
        $table->boolean('can_edit_products')->default(false);
        $table->boolean('can_delete_products')->default(false);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
