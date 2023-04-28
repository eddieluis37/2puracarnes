<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductsIdToLevelsProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('levels_products', function (Blueprint $table) {              
           $table->unsignedBigInteger('product_id')->after('id');
           $table->foreign('product_id')->references('id')->on('products');
           $table->text('description')->after('level')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('levels_products', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
}
