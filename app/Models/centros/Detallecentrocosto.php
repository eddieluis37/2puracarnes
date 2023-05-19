<?php

namespace App\Models\centros;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detallecentrocosto extends Model
{
    use HasFactory;
    protected $table = 'subcentro_costo';
	protected $fillable = ['name','status'];
}
