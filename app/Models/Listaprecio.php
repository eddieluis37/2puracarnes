<?php

namespace App\Models;

use App\Models\centros\Centrocosto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listaprecio extends Model
{
    use HasFactory;

    protected $fillable = ['centrocosto_id', 'nombre', 'tipo'];

    public function centrocosto()
    {
        return $this->belongsTo(Centrocosto::class);
    }
}
