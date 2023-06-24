<?php

namespace App\Models\shopping;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shopping_enlistment_details extends Model
{
    use HasFactory;
    protected $table = 'shopping_enlistment_details';
	protected $fillable = ['shopping_enlistment_id','products_id','stock_actual','conteo_fisico','kgrequeridos','newstock'];
}
