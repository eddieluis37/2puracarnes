<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meatcut extends Model
{
    use HasFactory;
    
	protected $fillable = ['category_id','name','description','status'];

}
