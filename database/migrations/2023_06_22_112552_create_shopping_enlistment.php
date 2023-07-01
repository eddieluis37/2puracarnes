<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoppingEnlistment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopping_enlistment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('users_id')->nullable();
            $table->foreign('users_id')->references('id')->on('users');
            /*$table->unsignedBigInteger('category_id');           
            $table->foreign('category_id')->references('id')->on('categories')->onDelete("cascade");
            $table->unsignedBigInteger('centrocosto_id')->nullable();
            $table->foreign('centrocosto_id')->references('id')->on('centro_costo');
            $table->unsignedBigInteger('meatcut_id')->nullable();           
            $table->foreign('meatcut_id')->references('id')->on('meatcuts')->onDelete("cascade");*/

            $table->unsignedBigInteger('enlistments_id')->nullable();
            $table->foreign('enlistments_id')->references('id')->on('enlistments');
            $table->unsignedBigInteger('category_id');           
            $table->foreign('category_id')->references('id')->on('categories')->onDelete("cascade");
            $table->unsignedBigInteger('productopadre_id')->nullable();
            $table->foreign('productopadre_id')->references('id')->on('products');
            $table->unsignedBigInteger('centrocosto_id')->nullable();
            $table->foreign('centrocosto_id')->references('id')->on('centro_costo');

            $table->decimal('stock_actual', 18, 2)->nullable(); // valor de cantidades de unidades sea KG
            $table->decimal('ultimo_conteo_fisico', 18, 2)->nullable(); // valor de cantidades de unidades sea KG
            $table->decimal('nuevo_stock', 18, 2)->nullable(); // valor de cantidades de unidades sea KG
            $table->date('fecha_shopping');
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
        Schema::dropIfExists('shopping_enlistment');
    }
}
