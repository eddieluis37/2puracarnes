<?php

namespace App\Models;

use App\Models\Sacrificiopollo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiopollo extends Model
{
    use HasFactory;

     protected $fillable = ['thirds_id', 'factura', 'plantasacrificio_id', 'clientsubproductos_uno_id', 'clientsubproductos_dos_id', 'cantidad', 'sacrificio', 'valor_kg_pollo', 'total_factura', 'promedio_pie_kg', 'peso_pie_planta', 'promedio_canal_fria_sala', 'peso_canales_pollo_planta', 'menudencia_pollo_kg', 'mollejas_corazones_kg', 'subtotal', 'promedio_canal_kg', 'menudencia_pollo_porc', 'mollejas_corazones_porc', 'despojos_mermas', 'porc_pollo', 'fecha_beneficio', 'fecha_cierre', 'lote', 'status'];

 
    public function plantasacrificio(){
        return $this->belongsTo(Sacrificiopollo::class);
    }

       public function third(){
    	return $this->belongsTo(Third::class);
    }

}
