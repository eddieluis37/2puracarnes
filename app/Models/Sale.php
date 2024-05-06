<?php

namespace App\Models;

use App\Models\centros\Centrocosto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'valor_a_pagar_efectivo', 'total', 'total_iva', 'items', 'cash', 'cambio', 'status', 'fecha', 'consecutivo', 'resol', 'user_id',
        'third_id', 'vendedor_id', 'domiciliario_id', 'centrocosto_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function centrocosto()
    {
        return $this->belongsTo(Centrocosto::class);
    }

    public function third()
    {
        return $this->belongsTo(Third::class);
    }


    public function thirds()
    {
        return $this->hasOne('App\Models\Third');
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }


    public function subcentrocosto()
    {
        return $this->belongsTo(Subcentrocosto::class, 'subcentrocostos_id', 'id');
    }

    // MUTATORS
    /*
    public function setTotalAttribute($value)
    {
        $priceBeforeSave = $this->attributes['total'];

        $priceFilter  = filter_var($priceBeforeSave, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        $this->attributes['total'] = $priceFilter;
    }
    */
}
