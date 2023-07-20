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

            $table->unsignedBigInteger('users_id')->nullable();
            $table->foreign('users_id')->references('id')->on('users');

            $table->unsignedBigInteger('centro_costo_origen_id')->nullable();
            $table->foreign('centro_costo_origen_id')->references('id')->on('centro_costo');
            
            $table->unsignedBigInteger('centro_costo_destino_id')->nullable();
            $table->foreign('centro_costo_destino_id')->references('id')->on('centro_costo');            
           
            $table->unsignedBigInteger('centro_costo_products_id')->nullable();
            $table->foreign('centro_costo_products_id')->references('id')->on('centro_costo_products');

            $table->decimal('quantity', 18, 2)->nullable(); // valor de cantidades de unidades trasladada

            $table->decimal('nuevo_stock_padre', 18, 2)->default(0);  
            $table->enum('inventario', ['pending', 'added'])->default('pending');
            $table->date('fecha_trasnfer');
            $table->date('fecha_cierre')->nullable();
            
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
        Schema::dropIfExists('transfers');
    }
}
