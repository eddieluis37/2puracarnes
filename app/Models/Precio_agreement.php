<?php

namespace App\Models;

use App\Models\Agreement;
use App\Models\Precio;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Precio_agreement extends Model
{
    use HasFactory;

     protected $fillable = ['line', 'agreement_id', 'product_id', 'precio', 'user_id', 'vendedor', 'descuento', 'valorfinal'];


     public function agreement()
	{
		return $this->belongsTo(Agreement::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}	

	 public function user()
	{
		return $this->belongsTo(User::class);
	}

	 

}
