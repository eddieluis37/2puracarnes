<?php

namespace App\Models\faster;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faster extends Model
{
    use HasFactory;

    protected $table = 'fasters';
	protected $fillable = ['users_id','categoria_id','centrocosto_id','nuevo_stock_padre' ,'fecha_faster','fecha_cierre','status'];
}