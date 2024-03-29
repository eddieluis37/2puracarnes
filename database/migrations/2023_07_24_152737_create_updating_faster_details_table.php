<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpdatingFasterDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('updating_faster_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('updating_faster_id')->nullable();
            $table->foreign('updating_faster_id')->references('id')->on('updating_faster');

            $table->unsignedBigInteger('products_id')->nullable();
            $table->foreign('products_id')->references('id')->on('products');
            
            $table->decimal('stock_actual', 18, 2)->nullable(); // valor de cantidades de unidades sea KG
            $table->decimal('conteo_fisico', 18, 2)->nullable(); // valor de cantidades en inventario tangible real           
            $table->decimal('kgrequeridos', 18, 2)->nullable();
            $table->decimal('newstock', 18, 2)->nullable();
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
        Schema::dropIfExists('updating_faster_details');
    }
}
