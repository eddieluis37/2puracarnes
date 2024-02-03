<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuentasPorCobrarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuentas_por_cobrars', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();           
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('parametrocontable_id')->nullable();           
            $table->foreign('parametrocontable_id')->references('id')->on('parametrocontables');

            $table->unsignedBigInteger('sale_id')->nullable();    
            $table->foreign('sale_id')->references('id')->on('sales'); 

            $table->unsignedBigInteger('third_id')->nullable();           
            $table->foreign('third_id')->references('id')->on('thirds');

            $table->enum('status',['0','1','2','3','4','5'])->default('0'); // 0 = PE, 1 = NC, 
            
            $table->date('fecha_inicial')->nullable();     
            $table->date('fecha_vencimiento')->nullable();     
            $table->decimal('deuda_inicial',12,0)->default(0);
            $table->decimal('deuda_x_cobrar',12,0)->default(0)->nullable();   
            $table->decimal('deuda_x_pagar',12,0)->nullable();
            $table->decimal('valor_anticipo',12,0)->default(0)->nullable();   
            $table->decimal('saldo_cartera',12,0)->default(0)->nullable();   


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
        Schema::dropIfExists('cuentas_por_cobrars');
    }
}
