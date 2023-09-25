<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parametrocontable extends Model
{
    use HasFactory;
    protected $fillable = ['codigo','nombre', 'tipoparametro', 'cuenta'];

	protected $table = 'parametrocontables';
}