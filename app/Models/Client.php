<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <--- Importante 1
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory; // <--- Importante 2: Esto activa el método factory()

    // Opcional: define qué campos se pueden llenar masivamente
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'rfc',
    ];
}