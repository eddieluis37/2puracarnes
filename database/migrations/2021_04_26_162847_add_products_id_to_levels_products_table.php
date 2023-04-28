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
            $table->foreignId('product_id')->constrained();
            $table->string('note')->after('level')->nullable();
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
            $table->dropColumn('note');
        });
    }
}
