<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUtilidadBeneficiopollosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utilidad_beneficiopollos', function (Blueprint $table) {
            $table->id();
               
            $table->unsignedBigInteger('user_id')->nullable();           
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('beneficiopollos_id');
            $table->foreign('beneficiopollos_id')->references('id')->on('beneficiopollos');         

            $table->unsignedBigInteger('products_id')->nullable();
            $table->foreign('products_id')->references('id')->on('products');

            $table->string('product_name', 50, 0)->nullable(); 

            $table->decimal('kilos',18, 2)->default(0)->nullable(); 
                        
            $table->decimal('totales_kilos',18, 2)->default(0)->nullable(); 

            $table->decimal('porcentaje_participacion', 18, 2)->nullable();
            $table->decimal('costo_unitario', 18, 2)->nullable();
            $table->decimal('costo_real', 18, 2)->nullable();
            $table->decimal('precio_kg_venta', 18, 2)->nullable();
            $table->decimal('ingresos_totales', 18, 2)->nullable();
            $table->decimal('participacion_venta', 18, 2)->nullable();
            $table->decimal('utilidad_dinero', 18, 2)->nullable();
            $table->decimal('porcentaje_utilidad', 18, 2)->nullable();
            $table->decimal('dinero_kilo', 18, 2)->nullable();
            $table->enum('status',['VALID','CANCELED'])->default('VALID');          
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
        Schema::dropIfExists('utilidad_beneficiopollos');
    }
}
