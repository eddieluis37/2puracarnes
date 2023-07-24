<?php

namespace App\Models\updating;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class updating_transfer_details extends Model
{
    use HasFactory;
    protected $table = 'updating_transfer_details';
	protected $fillable = ['updating_transfer_id','products_id','stock_actual','conteo_fisico','kgrequeridos','newstock'];
}
