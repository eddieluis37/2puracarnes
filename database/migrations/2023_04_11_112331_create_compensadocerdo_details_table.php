<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompensadocerdoDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compensadocerdo_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('compensadocerdos_id')->nullable();
            $table->foreign('compensadocerdos_id')->references('id')->on('compensadocerdos');

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
        Schema::dropIfExists('compensadocerdo_details');
    }
}
