<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotadebitoDetail extends Model
{
    use HasFactory;
      
    protected $fillable = ['price','quantity','product_id','sale_id','porciva','iva','total'];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    /* // Relacion inversa para reporte de ventas por productos
    public function saleDetail()
    {
        return $this->belongsTo(SaleDetail::class, 'sale_id', 'sale_id');
    } */
}
