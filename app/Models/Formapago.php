<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formapago extends Model
{

    use HasFactory;
    
    protected $fillable = ['codigo',
    'nombre', 
    'tipoformapago', 
    'cuenta'
    ];

	protected $table = 'formapagos';
}