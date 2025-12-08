<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Desactivamos timestamps para evitar el error de "updated_at"
    public $timestamps = false; 

    // --- ESTA ES LA FUNCIÓN QUE TE FALTABA ---
    // Define que cada detalle pertenece a un producto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Opcional: Define que cada detalle pertenece a una venta padre
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}