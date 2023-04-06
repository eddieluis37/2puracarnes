<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeneficiocerdosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficiocerdos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('thirds_id')->nullable();
            $table->foreign('thirds_id')->references('id')->on('thirds');

            $table->unsignedBigInteger('plantasacrificio_id')->nullable();
            $table->foreign('plantasacrificio_id')->references('id')->on('sacrificiocerdos');
            
            $table->bigInteger('cantidad')->nullable(); 
            
            $table->date('fecha_beneficio');

            $table->string('factura');

            $table->unsignedBigInteger('clientpieles_id')->nullable();
            $table->foreign('clientpieles_id')->references('id')->on('thirds');

            $table->unsignedBigInteger('clientvisceras_id')->nullable();
            $table->foreign('clientvisceras_id')->references('id')->on('thirds');
                      
            $table->string('lote');
            
            $table->boolean('status')->parent_select()->default(true)->nullable();            
         

      
            $table->decimal('sacrificio', 18, 2)->nullable();

            $table->decimal('fomento', 18, 2)->nullable();

            $table->decimal('deguello', 18, 2)->nullable();

            $table->decimal('bascula', 18, 2)->nullable();

            $table->decimal('transporte', 18, 2)->nullable();        
                                        
                             

            $table->decimal('pesopie1', 18, 2)->nullable();
            
            $table->decimal('pesopie2', 18, 2)->nullable();

            $table->decimal('pesopie3', 18, 2)->nullable();

          

            $table->decimal('costoanimal1', 18, 2)->nullable();

            $table->decimal('costoanimal2', 18, 2)->nullable();
            
            $table->decimal('costoanimal3', 18, 2)->nullable();    
                    
           

            $table->decimal('canalcaliente', 18, 2)->nullable();

            $table->decimal('canalfria', 18, 2)->nullable();  

            $table->decimal('canalplanta', 18, 2)->nullable();      

            $table->bigInteger('pieleskg')->nullable();

            $table->decimal('pielescosto', 18, 2)->nullable();
            
            $table->decimal('visceras', 18, 2)->nullable();

            
            # Totales

            $table->decimal('costopie1', 18, 2)->nullable();

            $table->decimal('costopie2', 18, 2)->nullable();

            $table->decimal('costopie3', 18, 2)->nullable();
            
             

            $table->decimal('tsacrificio', 18, 2)->nullable(); 

            $table->decimal('tfomento', 18, 2)->nullable();
            
            $table->decimal('tdeguello', 18, 2)->nullable();

            $table->decimal('tbascula', 18, 2)->nullable();

            $table->decimal('ttransporte', 18, 2)->nullable();

            $table->decimal('tpieles', 18, 2)->nullable();

            $table->decimal('tvisceras', 18, 2)->nullable();

            $table->decimal('tcanalfria', 18, 2)->nullable();     
                   
            $table->decimal('valorfactura', 18, 2)->nullable();  

            $table->decimal('costokilo', 18, 2)->nullable();

            $table->decimal('costo', 18, 2)->nullable();

            $table->decimal('totalcostos', 18, 2)->nullable();


            # Rendimiento   
            
            
            $table->decimal('pesopie', 18, 2)->nullable(); 

            $table->decimal('rtcanalcaliente', 18, 2)->nullable(); 

            $table->decimal('rtcanalplanta', 18, 2)->nullable();

            $table->decimal('rtcanalfria', 18, 2)->nullable();             

            $table->decimal('rendcaliente', 18, 2)->nullable();       

            $table->decimal('rendplanta', 18, 2)->nullable(); 

            $table->decimal('rendfrio', 18, 2)->nullable();  

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
        Schema::dropIfExists('beneficiocerdos');
    }
}
