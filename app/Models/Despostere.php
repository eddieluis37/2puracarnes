<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Despostere extends Model
{
    use HasFactory;

       protected $fillable = [  
        'user_id',
        'beneficior_id',
        'desposteftr_id',
        'fichatecnica_id',
        'product_id',
        'peso',
        'porcdesposte',
        'costo',
        'costo_kilo',
        'precio',
        'total',
        'porcventa',
        'porcutilidad',
        'peso_acomulado',
        'status'        
    ];


    public function beneficiores(){
        return $this->belongsTo(Beneficiore::class);
    }

    public function products(){
        return $this->belongsTo(Product::class);
    }  
}
