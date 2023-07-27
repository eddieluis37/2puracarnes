<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpdatingTransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('updating_transfer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('users_id')->nullable();
            $table->foreign('users_id')->references('id')->on('users');
            /*$table->unsignedBigInteger('category_id');           
            $table->foreign('category_id')->references('id')->on('categories')->onDelete("cascade");
            $table->unsignedBigInteger('centrocosto_id')->nullable();
            $table->foreign('centrocosto_id')->references('id')->on('centro_costo');
            $table->unsignedBigInteger('meatcut_id')->nullable();           
            $table->foreign('meatcut_id')->references('id')->on('meatcuts')->onDelete("cascade");*/

            $table->unsignedBigInteger('transfers_id')->nullable();
            $table->foreign('transfers_id')->references('id')->on('transfers');

            $table->unsignedBigInteger('category_id');           
            $table->foreign('category_id')->references('id')->on('categories')->onDelete("cascade");
            
            $table->unsignedBigInteger('productopadre_id')->nullable();
            $table->foreign('productopadre_id')->references('id')->on('products');

            $table->unsignedBigInteger('centrocostoOrigen_id')->nullable();
            $table->foreign('centrocostoOrigen_id')->references('id')->on('centro_costo');

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
        Schema::dropIfExists('updating_transfer');
    }
}
