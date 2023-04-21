<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unitofmeasure extends Model
{
    use HasFactory;
    protected $table = 'unitsofmeasures';
	protected $fillable = ['name','description','status'];
}
