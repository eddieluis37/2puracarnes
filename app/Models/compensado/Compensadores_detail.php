<?php

namespace App\Models\compensado;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compensadores_detail extends Model
{
    use HasFactory;

    protected $table = 'compensadores_details';
	protected $fillable = ['compensadores_id','products_id','pcompra', 'peso','iva','subtotal'];
}
