<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compensadores_detail extends Model
{
    use HasFactory;

    protected $table = 'compensadores_details';
    protected $fillable = ['compensadores_id', 'products_id', 'pcompra', 'peso', 'iva', 'subtotal'];

<<<<<<< HEAD
    public function compensadore()
    {
        return $this->belongsTo(Compensadores::class, 'compensadores_id', 'id');
=======
    
    public function compensadores()
    {
        return $this->belongsTo(Compensadore::class, 'compensadores_id');
>>>>>>> 618e9e6949849197efb0fed088c758b4d6186085
    }

    public function third()
    {
        return $this->belongsTo(Third::class, 'third_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id', 'id');
    }
}
            