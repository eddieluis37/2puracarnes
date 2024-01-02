<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleformapagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saleformapagos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id');    
            $table->foreign('sale_id')->references('id')->on('sales'); 
            $table->unsignedBigInteger('formapago_id');    
            $table->foreign('formapago_id')->references('id')->on('formapagos'); 
            $table->integer('diascredito');
            $table->string('telefonoasociado');
            $table->string('bancoorigen');
            $table->string('bancodestino');
            $table->string('numcheque');
            $table->string('descripcion');
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
        Schema::dropIfExists('saleformapagos');
    }
}
