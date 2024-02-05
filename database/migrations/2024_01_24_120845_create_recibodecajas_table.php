<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecibodecajasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recibodecajas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');           
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('third_id')->nullable();           
            $table->foreign('third_id')->references('id')->on('thirds'); 
            $table->unsignedBigInteger('sale_id');    
            $table->foreign('sale_id')->references('id')->on('sales');               
          /*   $table->unsignedBigInteger('subcentrocostos_id')->nullable();
            $table->foreign('subcentrocostos_id')->references('id')->on('subcentrocostos');  */
            $table->unsignedBigInteger('formapagos_id')->nullable();
            $table->foreign('formapagos_id')->references('id')->on('formapagos'); 
            $table->decimal('saldo',12,0)->default(0)->nullable();           
            $table->decimal('abono',12,0)->default(0)->nullable(); 
            $table->decimal('nuevo_saldo',12,0)->default(0)->nullable();            

            $table->date('fecha_elaboracion')->nullable();  
            $table->date('fecha_cierre')->nullable();    
            $table->string('consecutivo', 50, 0)->nullable();
            $table->bigInteger('consec')->length(50)->nullable();    
          
 
            $table->enum('status',['0','1','2','3','4','5'])->default('0');
            $table->enum('tipo',['0','1','2','3'])->default('0');    // 0 = Ninguno , 1 = RD - 1 Ingresos-Recibo de caja diario , RC - 2 Ingreso-Recibo de caja de cartera
            $table->enum('realizar_un',['Abono a deuda','Anticipo','Avanzado (Impuestos, descuentos, ajustes)'])->default('Abono a deuda','Anticipo');  
            $table->text('observations')->nullable(); // campo text area 
            
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
        Schema::dropIfExists('recibodecajas');
    }
}
