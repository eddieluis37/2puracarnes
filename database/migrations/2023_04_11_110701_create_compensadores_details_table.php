<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompensadoresDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compensadores_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('compensadores_id')->nullable();
            $table->foreign('compensadores_id')->references('id')->on('compensadores');

            $table->unsignedBigInteger('products_id')->nullable();
            $table->foreign('products_id')->references('id')->on('products');

            $table->double('precio_compra', 18, 2)->nullable();

            $table->bigInteger('qty')->nullable();

            $table->double('iva', 18, 2)->nullable();

            $table->double('subtotal', 18, 2)->nullable();


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
        Schema::dropIfExists('compensadores_details');
    }
}
