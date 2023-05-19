<?php

namespace App\Models\centros;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Centrocosto extends Model
{
    use HasFactory;
    protected $table = 'centro_costo';
	protected $fillable = ['name','status'];
}
