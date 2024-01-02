<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpdatingTransferDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('updating_transfer_details', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('updating_transfer_id')->nullable();
            $table->foreign('updating_transfer_id')->references('id')->on('updating_transfer');

            $table->unsignedBigInteger('products_id')->nullable();
            $table->foreign('products_id')->references('id')->on('products');

            $table->decimal('stock_actual', 18, 2)->nullable(); // valor de cantidades de unidades sea KG
         
            $table->decimal('conteo_tangible', 18, 2)->nullable(); // valor de cantidades en inventario tangible real           
         
            $table->decimal('kgrequeridos', 18, 2)->nullable();

            $table->decimal('nuevo_stock_origen', 18, 2)->nullable();

            $table->decimal('nuevo_stock_destino', 18, 2)->nullable();

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
        Schema::dropIfExists('updating_transfer_details');
    }
}
