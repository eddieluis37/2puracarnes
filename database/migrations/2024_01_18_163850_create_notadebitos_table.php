<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotadebitosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notadebitos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id');    
            $table->foreign('sale_id')->references('id')->on('sales'); 

            $table->unsignedBigInteger('user_id')->nullable();           
            $table->foreign('user_id')->references('id')->on('users');

            
            $table->enum('status',['0','1','2','3','4','5'])->default('0');
            
            $table->enum('tipo', ['ANULACION', 'REBAJA', 'DESCUENTO', 'RESCISION', 'OTROS'])->default('ANULACION');

            $table->decimal('items',10,0)->nullable();
            $table->decimal('total_iva',10,0)->default(0)->nullable();
            $table->decimal('total_otros_impuestos',10,0)->default(0)->nullable(); 
            $table->decimal('valor_total',12,0)->default(0)->nullable();     

            $table->string('observacion')->nullable();
            $table->date('fecha_notadebito')->nullable();       
            $table->date('fecha_cierre')->nullable();
            $table->date('fecha_vencimiento')->nullable(); 
            
            $table->string('consecutivo', 50, 0)->nullable();
            $table->bigInteger('consec')->length(50)->nullable();
            
            
            $table->string('resolucion', 50, 0)->nullable();







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
        Schema::dropIfExists('notadebitos');
    }
}
