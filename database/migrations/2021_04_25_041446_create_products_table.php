<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');           
            $table->unsignedBigInteger('level_product_id')->default(2);           
            $table->unsignedBigInteger('meatcut_id')->default(61);           
            $table->unsignedBigInteger('unitofmeasure_id')->default(1);           
            $table->string('name',255);
            $table->string('code', 20)->default(99999)->nullable();
            $table->string('barcode',25)->nullable();
            $table->decimal('cost',10,2)->default(0);
            $table->decimal('price_fama',10,0)->default(1)->nullable(); // precio en la linea de las famas
            $table->decimal('price_insti',10,0)->default(1)->nullable(); // precio en la linea de las institucional
            $table->decimal('price_horeca',10,0)->default(1)->nullable(); // precio en la linea de las Horeca
            $table->decimal('price_hogar',10,0)->default(1)->nullable(); // precio en la linea de las Hogar
            $table->decimal('iva',10)->default(1);
            $table->decimal('stock', 18, 2)->default(1); // valor de cantidades de unidades sea KG
            $table->decimal('fisico', 18, 2)->default(1); // valor de cantidades en inventario tangible real           
            $table->integer('alerts');
            $table->string('image',100)->nullable();
            $table->boolean('status')->parent_select()->default(true);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete("cascade");
            $table->foreign('level_product_id')->references('id')->on('levels_products')->onDelete("cascade");
            $table->foreign('meatcut_id')->references('id')->on('meatcuts')->onDelete("cascade");
            $table->foreign('unitofmeasure_id')->references('id')->on('unitsofmeasures')->onDelete("cascade");

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
        Schema::dropIfExists('products');
    }
}

