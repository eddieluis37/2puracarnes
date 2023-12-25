<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCompensadores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compensadores', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('users_id')->nullable();
            $table->foreign('users_id')->references('id')->on('users');

            $table->unsignedBigInteger('thirds_id')->nullable();
            $table->foreign('thirds_id')->references('id')->on('thirds');

            $table->unsignedBigInteger('centrocosto_id')->nullable();
            $table->foreign('centrocosto_id')->references('id')->on('centro_costo');

            $table->string('factura');

            $table->date('fecha_compensado');
            $table->date('fecha_cierre')->nullable();

            $table->boolean('status')->parent_select()->default(false)->nullable();            
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
        Schema::dropIfExists('compensadores');
    }
}
