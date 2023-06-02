<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiore extends Model
{
    use HasFactory;

     protected $fillable = ['thirds_id', 'plantasacrificio_id','cantidadmacho', 'valorunitariomacho','valortotalmacho','cantidadhembra','valorunitariohembra','valortotalhembra', 'cantidad', 'fecha_beneficio', 'fecha_cierre', 'factura', 'clientpieles_id', 'clientvisceras_id', 'lote', 'finca',  'sacrificio', 'fomento', 'deguello', 'bascula', 'transporte', 'pesopie1', 'pesopie2', 'pesopie3', 'costoanimal1', 'costoanimal2', 'costoanimal3', 'canalcaliente', 'canalfria', 'canalplanta', 'pieleskg', 'pielescosto', 'visceras', 'costopie1', 'costopie2', 'costopie3', 'tsacrificio', 'tfomento', 'tdeguello', 'tbascula', 'ttransporte', 'tpieles', 'tvisceras', 'tcanalfria', 'valorfactura', 'costokilo', 'costo', 'totalcostos', 'pesopie', 'rtcanalcaliente', 'rtcanalplanta', 'rtcanalfria', 'rendcaliente', 'rendplanta', 'rendfrio', 'status', 'status_beneficio'];


 
    public function plantasacrificio(){
        return $this->belongsTo(Sacrificio::class);
    }

       public function third(){
    	return $this->belongsTo(Third::class);
    }


}
