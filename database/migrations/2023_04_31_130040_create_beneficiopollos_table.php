<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeneficiopollosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficiopollos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('thirds_id')->nullable();
            $table->foreign('thirds_id')->references('id')->on('thirds');
            $table->string('factura');
            $table->unsignedBigInteger('plantasacrificio_id')->nullable();
            $table->foreign('plantasacrificio_id')->references('id')->on('sacrificiopollos');
            $table->unsignedBigInteger('clientsubproductos_uno_id')->nullable();
            $table->foreign('clientsubproductos_uno_id')->references('id')->on('thirds');
            $table->unsignedBigInteger('clientsubproductos_dos_id')->nullable();
            $table->foreign('clientsubproductos_dos_id')->references('id')->on('thirds');
            $table->bigInteger('cantidad')->nullable();
            $table->decimal('sacrificio', 18, 0)->nullable();
            $table->decimal('valor_kg_pollo', 18, 0)->nullable();
            $table->decimal('total_factura', 18, 0)->nullable();

            $table->decimal('promedio_pie_kg',10,0)->default(0)->nullable();
            $table->decimal('peso_pie_planta',10,0)->default(0)->nullable();
            $table->decimal('promedio_canal_fria_sala',10,0)->default(0)->nullable();
            $table->decimal('peso_canales_pollo_planta',10,0)->default(0)->nullable();

            $table->decimal('menudencia_pollo_kg',10,0)->default(0)->nullable();
            $table->decimal('mollejas_corazones_kg',10,0)->default(0)->nullable();
            $table->decimal('subtotal',10,0)->default(0)->nullable();
            $table->decimal('promedio_canal_kg',10,0)->default(0)->nullable();

            $table->decimal('menudencia_pollo_porc',10,0)->default(0)->nullable();
            $table->decimal('mollejas_corazones_porc',10,0)->default(0)->nullable();
            $table->decimal('despojos_mermas',10,0)->default(0)->nullable();
                    
            $table->decimal('kilos_pollo_entero',10,0)->default(0)->nullable(); 
            $table->decimal('kilos_menudencia',10,0)->default(0)->nullable(); 
            $table->decimal('kilos_mollejas_corazones',10,0)->default(0)->nullable(); 
            $table->decimal('totales_kilos',10,0)->default(0)->nullable(); 




            $table->unsignedBigInteger('clientpieles_id')->nullable();
            $table->foreign('clientpieles_id')->references('id')->on('thirds');

            $table->unsignedBigInteger('clientvisceras_id')->nullable();
            $table->foreign('clientvisceras_id')->references('id')->on('thirds');

          
            
            $table->date('fecha_beneficio');
            $table->date('fecha_cierre')->nullable();

      
                      
            $table->string('lote');
            
         
         

            $table->decimal('fomento', 18, 0)->nullable();

            $table->decimal('deguello', 18, 0)->nullable();

            $table->decimal('bascula', 18, 0)->nullable();

            $table->decimal('transporte', 18, 0)->nullable();        
                                        
                             

            $table->decimal('pesopie1', 18, 2)->nullable();
            
            $table->decimal('pesopie2', 18, 2)->nullable();

            $table->decimal('pesopie3', 18, 2)->nullable();

          

            $table->decimal('costoanimal1', 18, 0)->nullable();

            $table->decimal('costoanimal2', 18, 0)->nullable();
            
            $table->decimal('costoanimal3', 18, 0)->nullable();    

            $table->bigInteger('menudenciaskg')->nullable();

            $table->decimal('menudenciascosto', 18, 0)->nullable();
            
            $table->decimal('canalcaliente', 18, 2)->nullable();

            $table->decimal('canalfria', 18, 2)->nullable();
            
            $table->decimal('canalplanta', 18, 2)->nullable();
            
            $table->bigInteger('pieleskg')->nullable();
            
            $table->decimal('pielescosto', 18, 0)->nullable();
            
            $table->decimal('visceras', 18, 2)->nullable();                 
                  
            # Totales

            $table->decimal('costopie1', 18, 0)->nullable();

            $table->decimal('costopie2', 18, 0)->nullable();

            $table->decimal('costopie3', 18, 0)->nullable();
            
            $table->decimal('tmenudencias', 18, 0)->nullable();

            $table->decimal('tsacrificio', 18, 0)->nullable(); 

            $table->decimal('tfomento', 18, 0)->nullable();
            
            $table->decimal('tdeguello', 18, 0)->nullable();

            $table->decimal('tbascula', 18, 0)->nullable();

            $table->decimal('ttransporte', 18, 0)->nullable();

            $table->decimal('tpieles', 18, 0)->nullable();

            $table->decimal('tvisceras', 18, 0)->nullable();

            $table->decimal('tcanalfria', 18, 0)->nullable();     
                   
            $table->decimal('valorfactura', 18, 0)->nullable();  

            $table->decimal('costokilo', 18, 0)->nullable();

            $table->decimal('costo', 18, 0)->nullable();

            $table->decimal('totalcostos', 18, 0)->nullable();
            
            # Rendimiento   
            
            $table->decimal('pesopie', 18, 2)->nullable(); 

            $table->decimal('rtcanalcaliente', 18, 2)->nullable(); 

            $table->decimal('rtcanalplanta', 18, 2)->nullable();

            $table->decimal('rtcanalfria', 18, 2)->nullable();             

            $table->decimal('rendcaliente', 18, 2)->nullable();       

            $table->decimal('rendplanta', 18, 2)->nullable(); 

            $table->decimal('rendfrio', 18, 2)->nullable();       

            $table->boolean('status')->parent_select()->default(true)->nullable();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beneficiopollos');
    }
}
