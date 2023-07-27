<?php

namespace App\Models\transfer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $table = 'transfers';
	protected $fillable = ['users_id','categoria_id','centrocostoOrigen_id','nuevo_stock_padre' ,'fecha_alistamiento','fecha_cierre','status'];
}
