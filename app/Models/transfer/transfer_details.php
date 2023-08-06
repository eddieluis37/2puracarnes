<?php

namespace App\Models\transfer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transfer_details extends Model
{
    use HasFactory;
    protected $table = 'transfer_details';
	protected $fillable = ['transfers_id','products_id','kgrequeridos','nuevo_stock_origen', 'nuevo_stock_destino', 'status'];
}
