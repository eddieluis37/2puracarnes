<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotacreditosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notacreditos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id');    
            $table->foreign('sale_id')->references('id')->on('sales'); 
            $table->enum('status',['0','1','2','3','4','5'])->default('0');
            $table->enum('tipo', ['DEVOLUCION', 'ANULACION'])->default('DEVOLUCION');
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
        Schema::dropIfExists('notacreditos');
    }
}
