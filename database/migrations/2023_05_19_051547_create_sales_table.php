<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
              
            $table->unsignedBigInteger('user_id');           
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('third_id')->nullable();           
            $table->foreign('third_id')->references('id')->on('thirds');         
            
            $table->unsignedBigInteger('vendedor_id')->nullable();           
            $table->foreign('vendedor_id')->references('id')->on('thirds'); 
            
            $table->unsignedBigInteger('domiciliario_id')->nullable();           
            $table->foreign('domiciliario_id')->references('id')->on('thirds'); 
            
            $table->unsignedBigInteger('centrocosto_id')->nullable();
            $table->foreign('centrocosto_id')->references('id')->on('centro_costo');      

            $table->decimal('total',10,2);
            $table->decimal('items',10,2);
            $table->decimal('cash',10,2);
            $table->decimal('change',10,2);    
            $table->enum('status',['0','1','2','3','4','5'])->default('0');

            $table->date('fecha_venta')->nullable();       
            $table->date('fecha_cierre')->nullable();
            $table->string('consecutivo', 50, 0)->nullable();
            $table->bigInteger('consec')->length(50)->nullable();
                

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
        Schema::dropIfExists('sales');
    }
}
