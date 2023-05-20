<?php

namespace App\Models\compensado;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compensadores extends Model
{
    use HasFactory;

    protected $table = 'compensadores';
	protected $fillable = ['users_id','categoria_id','thirds_id', 'centrocosto_id','factura','status'];
}
