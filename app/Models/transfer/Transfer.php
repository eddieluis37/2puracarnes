<?php

namespace App\Models\transfer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $table = 'transfers';
	protected $fillable = ['users_id','categoria_id','centrocostoOrigen_id','centrocostoDestino_id','nuevo_stock_origen','nuevo_stock_destino','fecha_tranfer','fecha_cierre','status'];
}
