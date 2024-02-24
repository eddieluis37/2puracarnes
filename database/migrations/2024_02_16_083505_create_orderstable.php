<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');           
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('third_id')->nullable();           
            $table->foreign('third_id')->references('id')->on('thirds');         
            
            $table->unsignedBigInteger('vendedor_id')->nullable();           
            $table->foreign('vendedor_id')->references('id')->on('thirds'); 
            
            $table->unsignedBigInteger('formapago_id')->nullable();           
            $table->foreign('formapago_id')->references('id')->on('formapagos'); 
            
            $table->unsignedBigInteger('alistador_id')->nullable();           
            $table->foreign('alistador_id')->references('id')->on('thirds'); 
            
            $table->unsignedBigInteger('domiciliario_id')->nullable();           
            $table->foreign('domiciliario_id')->references('id')->on('thirds');                   
                 
            $table->unsignedBigInteger('centrocosto_id')->nullable();
            $table->foreign('centrocosto_id')->references('id')->on('centro_costo'); 

            $table->unsignedBigInteger('subcentrocostos_id')->nullable();
            $table->foreign('subcentrocostos_id')->references('id')->on('subcentrocostos');
 
            $table->unsignedBigInteger('caja_id')->nullable();
            $table->foreign('caja_id')->references('id')->on('cajas');

            $table->decimal('items',10,0);
            
            $table->decimal('total_bruto',12,0)->default(0)->nullable();
            $table->decimal('descuentos',12,0)->default(0)->nullable();
            $table->decimal('subtotal',12,0)->default(0)->nullable();
            $table->decimal('total_iva',10,0)->default(0)->nullable();
            $table->decimal('total_otros_impuestos',10,0)->default(0)->nullable(); 
            $table->decimal('total',12,0)->default(0)->nullable();
            $table->decimal('total_otros_descuentos',12,0)->default(0)->nullable();
            $table->decimal('valor_a_pagar_efectivo',12,0)->default(0)->nullable();  
            $table->decimal('total_valor_a_pagar',12,0)->default(0)->nullable();  
            $table->decimal('total_utilidad',12,0)->default(0)->nullable();           

            /* $table->unsignedBigInteger('forma_pago_tarjeta_id')->nullable();
            $table->foreign('forma_pago_tarjeta_id')->references('id')->on('formapagos');
            
            $table->unsignedBigInteger('forma_pago_otros_id')->nullable();
            $table->foreign('forma_pago_otros_id')->references('id')->on('formapagos');

            $table->unsignedBigInteger('forma_pago_credito_id')->nullable();
            $table->foreign('forma_pago_credito_id')->references('id')->on('formapagos');

            $table->string('codigo_pago_tarjeta', 50)->nullable();
            $table->string('codigo_pago_otros', 50)->nullable();
            $table->string('codigo_pago_credito', 50)->nullable();

            $table->decimal('valor_a_pagar_tarjeta',12,0)->nullable();
            $table->decimal('valor_a_pagar_otros',12,0)->default(0)->nullable();
            $table->decimal('valor_a_pagar_credito', 12, 0)->nullable();

            $table->decimal('total_valor_a_pagar',12,0)->default(0)->nullable();     
            $table->decimal('valor_pagado',12,0)->default(0)->nullable();           
            $table->decimal('cambio',12,0)->default(0)->nullable(); 
 */
            $table->date('fecha_order')->nullable(); 
            $table->date('fecha_cierre')->nullable();  
            $table->date('fecha_entrega')->nullable();
            $table->time('hora_inicial_entrega')->nullable(); 
            $table->time('hora_final_entrega')->nullable();

            $table->string('direccion_envio', 150, 0)->nullable();

            $table->string('consecutivo', 50, 0)->nullable();
            $table->bigInteger('consec')->length(50)->nullable();
            $table->string('resolucion', 50, 0)->nullable();          
            $table->enum('tipo',['0','1','2','3','4','5'])->default('0');    // 0 = Mostrador , 1 =  Domicilio  
            $table->string('observacion')->nullable(); 
            $table->enum('status',['0','1','2','3','4','5'])->default('0');  

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
        Schema::dropIfExists('orders');
    }
}
