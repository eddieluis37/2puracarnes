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
            $table->unsignedBigInteger('level_product_id');           
            $table->unsignedBigInteger('meatcut_id');           
            $table->unsignedBigInteger('unitofmeasure_id');           
            $table->string('name',255);
            $table->string('code', 20)->unique()->nullable();
            $table->string('barcode',25)->nullable();
            $table->decimal('cost',10,2)->default(0);
            $table->decimal('price',10,2)->default(0);
            $table->decimal('iva',10)->default(0);
            $table->integer('stock');
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

