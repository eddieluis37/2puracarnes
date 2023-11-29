<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained();
            $table->decimal('price',10,2);
            $table->decimal('quantity',10,2);
            $table->decimal('porciva',10,2)->default(0)->nullable(); 
            $table->decimal('iva',10,2)->default(0)->nullable(); 
            $table->decimal('total_bruto',12,0)->default(0)->nullable(); 
            $table->decimal('total',12,0)->default(0)->nullable(); 
            $table->foreignId('product_id')->constrained(); 
   

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
        Schema::dropIfExists('sale_details');
    }
}
