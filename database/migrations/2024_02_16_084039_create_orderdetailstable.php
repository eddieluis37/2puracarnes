<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained();
            $table->foreignId('product_id')->constrained(); 
            $table->decimal('quantity',8,2)->default(0)->nullable(); 
            $table->decimal('costo_prod',12,0)->default(0)->nullable();        
            $table->decimal('price',10,2);
            $table->decimal('porc_desc_prod',10,2)->default(0)->nullable();
            $table->decimal('descuento_prod',12,0)->default(0)->nullable();
            $table->decimal('descuento_cliente',10,0)->default(0)->nullable();       
            $table->decimal('total_bruto',12,0)->default(0)->nullable();
            $table->decimal('total_costo',12,0)->default(0)->nullable();  
            $table->decimal('utilidad',12,0)->default(0)->nullable(); 
            $table->decimal('porc_utilidad',10,2)->default(0)->nullable(); 
            $table->decimal('porc_iva',10,2)->default(0)->nullable(); 
            $table->decimal('iva',10,0)->default(0)->nullable();
            $table->decimal('porc_otro_impuesto',10,2)->default(0)->nullable(); 
            $table->decimal('otro_impuesto',12,0)->default(0)->nullable(); 
            $table->decimal('total',12,0)->default(0)->nullable(); 
            $table->string('observaciones')->nullable();
            $table->decimal('quantity_despachada',8,2)->default(0)->nullable();             
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
        Schema::dropIfExists('order_details');
    }
}
