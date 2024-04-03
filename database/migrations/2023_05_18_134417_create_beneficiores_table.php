<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeneficioresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficiores', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('centrocosto_id')->nullable();
            $table->foreign('centrocosto_id')->references('id')->on('centro_costo');

            $table->unsignedBigInteger('thirds_id')->nullable();
            $table->foreign('thirds_id')->references('id')->on('thirds');

            $table->unsignedBigInteger('plantasacrificio_id')->nullable();
            $table->foreign('plantasacrificio_id')->references('id')->on('sacrificios');
            
            $table->unsignedBigInteger('clientpieles_id')->nullable();
            $table->foreign('clientpieles_id')->references('id')->on('thirds');

            $table->unsignedBigInteger('clientvisceras_id')->nullable();
            $table->foreign('clientvisceras_id')->references('id')->on('thirds');
            
            $table->unsignedBigInteger('products_id')->nullable();
            $table->foreign('products_id')->references('id')->on('products');

            $table->bigInteger('cantidadmacho')->nullable(); 
            $table->bigInteger('valorunitariomacho')->nullable(); 
            $table->bigInteger('valortotalmacho')->nullable(); 
            $table->bigInteger('cantidadhembra')->nullable(); 
            $table->bigInteger('valorunitariohembra')->nullable(); 
            $table->bigInteger('valortotalhembra')->nullable(); 
            $table->bigInteger('cantidad')->nullable(); 
            
            $table->date('fecha_beneficio');
            $table->date('fecha_cierre')->nullable();

            $table->string('factura');

            $table->string('lote');
            $table->string('finca');
         
            $table->decimal('sacrificio', 18, 0)->nullable();

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

            # status
            $table->boolean('status')->parent_select()->default(true)->nullable();            
            $table->string('status_beneficio')->parent_select()->default('en proceso')->nullable();            

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
        Schema::dropIfExists('beneficiores');
    }
}
