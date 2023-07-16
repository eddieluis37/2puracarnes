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
            $table->unsignedBigInteger('from_cost_center_id')->nullable();
            $table->foreign('from_cost_center_id')->references('id')->on('centro_costo');
            
            $table->unsignedBigInteger('to_cost_center_id')->nullable();
            $table->foreign('to_cost_center_id')->references('id')->on('centro_costo');
            
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->foreign('categoria_id')->references('id')->on('categories');            
            
            $table->unsignedBigInteger('centro_costo_products_id')->nullable();
            $table->foreign('centro_costo_products_id')->references('id')->on('centro_costo_products');

            $table->decimal('quantity', 18, 2)->nullable(); // valor de cantidades de unidades trasladada

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
