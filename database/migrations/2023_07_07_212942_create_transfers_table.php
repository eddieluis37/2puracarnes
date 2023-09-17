<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('users_id')->nullable();
            $table->foreign('users_id')->references('id')->on('users');

            $table->unsignedBigInteger('centrocostoOrigen_id')->nullable();
            $table->foreign('centrocostoOrigen_id')->references('id')->on('centro_costo');

            $table->unsignedBigInteger('centrocostoDestino_id')->nullable();
            $table->foreign('centrocostoDestino_id')->references('id')->on('centro_costo');

            $table->enum('inventario', ['pending', 'added'])->default('pending');
            $table->date('fecha_tranfer');
            $table->date('fecha_cierre')->nullable();

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
        Schema::dropIfExists('transfers');
    }
}
