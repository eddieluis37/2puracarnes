<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemporaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Se crea la tabla si no existe, para almacenar el peso acumulado de las compras compensadas
        Schema::create('temporary_accumulatedWeights', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->decimal('accumulated_weight', 8, 2);
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
        Schema::dropIfExists('temporary_accumulatedWeights');
    }
}
