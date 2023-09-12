<?php

namespace App\Models\updating;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class updating_faster extends Model
{
    use HasFactory;
    protected $table = 'updating_faster';
	protected $fillable = [
        'users_id',
        'transfers_id',
        'category_id',
        'productopadre_id',
        'centrocosto_id',
        'stock_actual','ultimo_conteo_fisico','nuevo_stock','fecha_shopping'];
}