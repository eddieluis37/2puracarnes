<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sacrificio extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'dni',       
        'address',
        'phone',
        'email',
        'sacrificio',
        'fomento',
        'deguello',
        'bascula',
        'transporte',
    ];

}
