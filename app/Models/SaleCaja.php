<?php

namespace App\Models;

use App\Models\caja\Caja;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SaleCaja extends Model
{
    use HasFactory;

    protected $table = 'sale_caja';

    public function venta()
    {
        return $this->belongsTo(Sale::class, 'sale_id', 'id');
    }

    public function caja()
    {
        return $this->belongsTo(Caja::class, 'caja_id', 'id');
    }
}
