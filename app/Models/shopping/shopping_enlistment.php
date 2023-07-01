<?php

namespace App\Models\shopping;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shopping_enlistment extends Model
{
    use HasFactory;
    protected $table = 'shopping_enlistment';
	protected $fillable = [
        'users_id',
        'enlistments_id',
        'category_id',
        'productopadre_id',
        'centrocosto_id',
        'stock_actual','ultimo_conteo_fisico','nuevo_stock','fecha_shopping'];
}
