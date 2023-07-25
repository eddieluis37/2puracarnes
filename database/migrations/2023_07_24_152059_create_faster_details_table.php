<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFasterDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faster_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fasters_id')->nullable();
            $table->foreign('fasters_id')->references('id')->on('fasters');

            $table->unsignedBigInteger('products_id')->nullable();
            $table->foreign('products_id')->references('id')->on('products');

            $table->decimal('kgrequeridos', 18, 2)->nullable();
            $table->decimal('newstock', 18, 2)->nullable();

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
        Schema::dropIfExists('faster_details');
    }
}
