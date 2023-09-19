<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Centro_costo_product extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function centroCosto()
    {
        return $this->belongsTo(CentroCosto::class, 'centrocosto_id');
    }
    
}
