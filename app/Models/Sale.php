<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['total','items','cash','change','status','user_id', 'third_id','vendedor_id','domiciliario_id','centrocosto_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
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
