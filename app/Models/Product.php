<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'barcode',
        'name',
        'category_id', 
        'price',
        'stock',
        'expiration_date',
        'has_iva',
    ];

    protected $casts = [
        'expiration_date' => 'date',
        'has_iva' => 'boolean',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}