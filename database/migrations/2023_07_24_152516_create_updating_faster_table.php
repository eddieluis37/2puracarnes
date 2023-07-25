<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpdatingFasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('updating_faster', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('users_id')->nullable();
            $table->foreign('users_id')->references('id')->on('users');          

            $table->unsignedBigInteger('fasters_id')->nullable();
            $table->foreign('fasters_id')->references('id')->on('fasters');

            $table->unsignedBigInteger('category_id');           
            $table->foreign('category_id')->references('id')->on('categories')->onDelete("cascade");

            $table->unsignedBigInteger('productopadre_id')->nullable();
            $table->foreign('productopadre_id')->references('id')->on('products');

            $table->unsignedBigInteger('centrocosto_id')->nullable();      
            $table->foreign('centrocosto_id')->references('id')->on('centro_costo');

            $table->decimal('stock_actual', 18, 2)->nullable(); // valor de cantidades de unidades sea KG
            $table->decimal('ultimo_conteo_fisico', 18, 2)->nullable(); // valor de cantidades de unidades sea KG
            $table->decimal('nuevo_stock', 18, 2)->nullable(); // valor de cantidades de unidades sea KG
            $table->date('fecha_updating');
            $table->boolean('status')->parent_select()->default(true);
            
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
        Schema::dropIfExists('updating_faster');
    }
}
