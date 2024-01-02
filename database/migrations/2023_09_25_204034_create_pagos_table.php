<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sale_id');    
            $table->foreign('sale_id')->references('id')->on('sales'); 
            
            $table->unsignedBigInteger('formapago_id');    
            $table->foreign('formapago_id')->references('id')->on('formapagos');

            $table->date('fecha_pago')->nullable();     

            $table->string('tipo_doc');

            $table->decimal('valor_pagado', 18, 0)->default(0)->nullable();
            
            $table->string('concepto');

            $table->string('observacion');
                     
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
        Schema::dropIfExists('pagos');
    }
}
