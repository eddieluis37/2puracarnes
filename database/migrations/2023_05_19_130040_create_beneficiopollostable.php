<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeneficiopollosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficiopollos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('centrocosto_id')->nullable();
            $table->foreign('centrocosto_id')->references('id')->on('centro_costo');

            $table->unsignedBigInteger('thirds_id')->nullable();
            $table->foreign('thirds_id')->references('id')->on('thirds');
            
            $table->string('factura');
            $table->unsignedBigInteger('plantasacrificio_id')->nullable();
            $table->foreign('plantasacrificio_id')->references('id')->on('sacrificiopollos');
            $table->unsignedBigInteger('clientsubproductos_uno_id')->nullable();
            $table->foreign('clientsubproductos_uno_id')->references('id')->on('thirds');
            $table->unsignedBigInteger('clientsubproductos_dos_id')->nullable();
            $table->foreign('clientsubproductos_dos_id')->references('id')->on('thirds');
            $table->bigInteger('cantidad')->nullable();
            $table->decimal('sacrificio', 18, 2)->nullable();
            $table->decimal('valor_kg_pollo', 18, 2)->nullable();
            $table->decimal('total_factura', 18, 2)->nullable();

            $table->decimal('promedio_pie_kg', 18, 2)->default(0)->nullable();
            $table->decimal('peso_pie_planta', 18, 2)->default(0)->nullable();
            $table->decimal('promedio_canal_fria_sala', 18, 2)->default(0)->nullable();
            $table->decimal('peso_canales_pollo_planta',18, 2)->default(0)->nullable();

            $table->decimal('menudencia_pollo_kg',18, 2)->default(0)->nullable();
            $table->decimal('mollejas_corazones_kg',18, 2)->default(0)->nullable();
            $table->decimal('subtotal',18, 2)->default(0)->nullable();
            $table->decimal('promedio_canal_kg',18, 2)->default(0)->nullable();

            $table->decimal('menudencia_pollo_porc',18, 2)->default(0)->nullable();
            $table->decimal('mollejas_corazones_porc',18, 2)->default(0)->nullable();
            $table->decimal('despojos_mermas',18, 2)->default(0)->nullable();
            $table->decimal('porc_pollo',18, 2)->default(0)->nullable();                 
            
            $table->date('fecha_beneficio');
            $table->date('fecha_cierre')->nullable();

                          
            $table->string('lote');
         
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
        Schema::dropIfExists('beneficiopollos');
    }
}
