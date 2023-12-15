<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParametrocontablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametrocontables', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('categorias_contable_id');    
            $table->foreign('categorias_contable_id')->references('id')->on('categorias_contables');

            $table->unsignedBigInteger('clases_contable_id');   
            $table->foreign('clases_contable_id')->references('id')->on('clases_contables');

            $table->unsignedBigInteger('relaciones_contable_id');   
            $table->foreign('relaciones_contable_id')->references('id')->on('relaciones_contables');

            $table->enum('vencimientos', ['No maneja', 'En cartera', 'En Proveedores'])->default('No maneja');

            $table->string('codigo')->unique();
            $table->string('nombre');            


            $table->boolean('status')->parent_select()->default(true)->nullable();

            

            /* $table->string('tipoparametro'); */
            
          /*   $table->string('cuenta'); */
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
        Schema::dropIfExists('parametrocontables');
    }
}

