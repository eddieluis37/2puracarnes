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
            $table->decimal('precio',10,0);
            $table->decimal('porciva',10,2);
            $table->decimal('iva',10,2);
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
