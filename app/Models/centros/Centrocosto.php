<?php

namespace App\Models\centros;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Centrocosto extends Model
{
    use HasFactory;
    protected $table = 'centro_costo';
	protected $fillable = ['name','status'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'centro_costo_products', 'centro_costo_id', 'product_id')
                    ->withPivot('quantity');
    }
}
