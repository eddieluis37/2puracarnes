<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNichoMercadoCentroCostoProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nicho_mercado_centro_costo_products', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('nicho_mercados_id')->nullable();
            $table->foreign('nicho_mercados_id')->references('id')->on('nicho_mercados');

            $table->unsignedBigInteger('centrocosto_id')->nullable();
            $table->foreign('centrocosto_id')->references('id')->on('centro_costo');    

            $table->unsignedBigInteger('products_id')->nullable();
            $table->foreign('products_id')->references('id')->on('products');

            $table->decimal('precio',10,2)->default(0);
            
            $table->decimal('iva',10)->default(0);

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
        Schema::dropIfExists('nicho_mercado_centro_costo_products');
    }
}
