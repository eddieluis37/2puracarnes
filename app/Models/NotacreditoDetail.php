<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotacreditoDetail extends Model
{
    use HasFactory;

    protected $fillable = ['price', 'quantity', 'product_id', 'sale_id', 'porciva', 'iva', 'total'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /* //Relacion inversa para reporte sales por producto 
    public function saleDetail()
    {
        return $this->belongsToMany(SaleDetail::class, 'product_id', 'product_id')
        ->withPivot('quantity', 'price');
    } */
}
