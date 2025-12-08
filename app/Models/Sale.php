<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    // Permitimos guardar todos los campos sin restricciones
    protected $guarded = [];

    // --- ESTA ES LA FUNCIÓN QUE TE FALTABA ---
    // Relación: Una venta pertenece a un Usuario (Cajero)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Una venta tiene muchos detalles
    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }
}