<?php

namespace App\Models\alistamiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alistamiento extends Model
{
    use HasFactory;

    protected $table = 'enlistments';
	protected $fillable = ['users_id','categoria_id','centrocosto_id','fecha_alistamiento','fecha_cierre','status'];
}
