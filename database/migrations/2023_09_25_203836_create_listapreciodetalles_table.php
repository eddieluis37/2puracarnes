<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListapreciodetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listapreciodetalles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('listaprecio_id');    
            $table->foreign('listaprecio_id')->references('id')->on('listaprecios'); 
            $table->unsignedBigInteger('product_id');    
            $table->foreign('product_id')->references('id')->on('products');
            $table->decimal('costo',10,0)->default(0)->nullable();
            $table->decimal('porc_util_proyectada',10,0)->default(18.00)->nullable();
            $table->decimal('precio_proyectado',10,0)->nullable();
            $table->decimal('precio',10,0)->default(0)->nullable();                     
            $table->decimal('porc_descuento',10,2)->default(0)->nullable();
            $table->decimal('utilidad',10,2)->default(2350)->nullable();
            $table->decimal('porc_utilidad', 10, 2)->default(16.79)->nullable();
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
        Schema::dropIfExists('listapreciodetalles');
    }
}
