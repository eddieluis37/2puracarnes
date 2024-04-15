<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Despostepollo extends Model
{
    use HasFactory;

    protected $fillable = [  
        'user_id',
        'beneficiopollos_id',
        'products_id',
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

    public function beneficiopollo(){
        return $this->belongsTo(Beneficiopollo::class);
    }

    public function products(){
        return $this->belongsTo(Product::class);
    }  
}
