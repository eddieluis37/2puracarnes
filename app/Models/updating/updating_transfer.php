<?php

namespace App\Models\updating;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class updating_transfer extends Model
{
    use HasFactory;
    protected $table = 'updating_transfer';
	protected $fillable = [
        'users_id',
        'transfers_id',
        'category_id',
        'producto_id',
        'centrocostoOrigen_id',
        'stock_actual','ultimo_conteo_fisico','nuevo_stock','fecha_updating'];
}
