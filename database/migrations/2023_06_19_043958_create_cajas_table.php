<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCajasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cajas', function (Blueprint $table) {
            $table->id();        

            $table->unsignedBigInteger('user_id');           
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('centrocosto_id')->nullable();
            $table->foreign('centrocosto_id')->references('id')->on('centro_costo');

            $table->unsignedBigInteger('cajero_id');           
            $table->foreign('cajero_id')->references('id')->on('users');

            $table->decimal('base',10,0)->nullable();
            
            $table->decimal('efectivo',10,0)->nullable();

            $table->decimal('retiro_caja',10,0)->nullable();

            $table->decimal('total',10,0)->nullable();

            $table->decimal('valor_real',10,0)->nullable();
            
            $table->decimal('diferencia',10,0)->nullable();

            $table->dateTime('fecha_hora_inicio')->nullable();

            $table->dateTime('fecha_hora_cierre')->nullable();

            $table->enum('estado', ['close', 'open'])->default('open');

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
        Schema::dropIfExists('cajas');
    }
}
