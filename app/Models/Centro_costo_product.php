<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Centro_costo_product extends Model
{
    use HasFactory;

    protected $fillable = ['centrocosto_id', 'products_id', 'tipoinventario', 'name', 'code', 'barcode', 'cost', 'price_fama', 'price_insti', 'price_horeca', 'price_hogar', 'iva', 'stock', 'alerts', 'image'];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function centroCosto()
    {
        return $this->belongsTo(CentroCosto::class, 'centrocosto_id');
    }

    public function sale_details()
    {
        return $this->belongsToMany(SaleDetail::class, 'saledetail_ccps', 'centro_costo_product_id', 'saledetail_id')
            ->withPivot('venta_real', 'cto_venta_total');
    }
    
}
