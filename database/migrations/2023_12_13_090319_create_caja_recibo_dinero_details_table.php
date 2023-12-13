<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCajaReciboDineroDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caja_recibo_dinero_details', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('caja_id');           
            $table->foreign('caja_id')->references('id')->on('cajas');

            $table->unsignedBigInteger('user_id');           
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->unsignedBigInteger('third_id')->nullable();
            $table->foreign('third_id')->references('id')->on('thirds');

            $table->decimal('quantity',10,2);
            $table->decimal('price',10,2);
            $table->decimal('porc_desc',10,2)->default(0)->nullable();
            $table->decimal('descuento',12,0)->default(0)->nullable();
            $table->decimal('descuento_cliente',10,0)->default(0)->nullable();            
            $table->decimal('porc_iva',10,2)->default(0)->nullable(); 
            $table->decimal('iva',10,0)->default(0)->nullable();
            $table->decimal('porc_otro_impuesto',10,2)->default(0)->nullable(); 
            $table->decimal('otro_impuesto',12,0)->default(0)->nullable(); 
            $table->decimal('total_bruto',12,0)->default(0)->nullable();        
            $table->decimal('total',12,0)->default(0)->nullable(); 
            
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
        Schema::dropIfExists('caja_recibo_dinero_details');
    }
}
