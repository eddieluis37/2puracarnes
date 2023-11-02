<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListapreciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listaprecios', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('users_id')->nullable();
            $table->foreign('users_id')->references('id')->on('users');

            $table->unsignedBigInteger('centrocosto_id')->nullable();
            $table->foreign('centrocosto_id')->references('id')->on('centro_costo'); 
            $table->string('nombre')->unique();
            $table->enum('tipo',['NICHO','GENERAL'])->default('NICHO');
            $table->enum('status_dos', ['PENDIENTE', 'APROBADO'])->default('APROBADO');
            $table->date('fecha_listado')->nullable();
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
        Schema::dropIfExists('listaprecios');
    }
}
