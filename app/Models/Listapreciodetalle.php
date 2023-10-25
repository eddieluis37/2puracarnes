<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listapreciodetalle extends Model
{
    use HasFactory;

    protected $table = 'listapreciodetalles';
    protected $fillable = ['listaprecio_id', 'product_id', 'precio', 'porciva', 'iva'];
}
