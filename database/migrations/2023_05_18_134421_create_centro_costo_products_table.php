<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCentroCostoProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centro_costo_products', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('centrocosto_id')->nullable();
            $table->foreign('centrocosto_id')->references('id')->on('centro_costo');           

            $table->unsignedBigInteger('products_id')->nullable();
            $table->foreign('products_id')->references('id')->on('products');          

            $table->string('tipoinventario')->default(0)->nullable(); //Inventario Inicial / Final 

            //INVENTARIO EN UNIDADES (KG)
            $table->decimal('invinicial', 18, 2)->default(0)->nullable(); //Inventario Inicial
            $table->decimal('compralote', 18, 2)->default(0)->nullable(); // Compra del lote
            $table->decimal('alistamiento', 18, 2)->default(0)->nullable(); //Alistamiento
            $table->decimal('compensados', 18, 2)->default(0)->nullable(); // Compensados          
            $table->decimal('trasladoing', 18, 2)->default(0)->nullable(); // Ingreso por traslados
            $table->decimal('trasladosal', 18, 2)->default(0)->nullable(); // Salida por traslados
            $table->decimal('venta', 18, 2)->default(0)->nullable(); // Ventas
            $table->decimal('notacredito', 18, 2)->default(0)->nullable(); // NotaCredito
            $table->decimal('notadebito', 18, 2)->default(0)->nullable(); // NotaDedito
            $table->decimal('venta_real', 18, 2)->default(0)->nullable(); // Ventas reales 
            $table->decimal('stock', 18, 2)->default(0)->nullable(); //Stock ideal en tiempo real del sistema
            $table->decimal('fisico', 18, 2)->default(0)->nullable(); //Inventario Final

            //INVENTARIO EN COSTO 
            $table->decimal('price_fama',10,2)->default(1)->nullable(); // precio en la linea de las famas
            $table->decimal('cto_invinicial', 18, 2)->default(0)->nullable(); //Inventario Inicial
            $table->decimal('cto_compralote', 18, 2)->default(0)->nullable(); // Compra del lote
            $table->decimal('cto_alistamiento', 18, 2)->default(0)->nullable(); //Alistamiento
            $table->decimal('cto_compensados', 18, 2)->default(0)->nullable(); // Compensados          
            $table->decimal('cto_trasladoing', 18, 2)->default(0)->nullable(); // Ingreso por traslados
            $table->decimal('cto_trasladosal', 18, 2)->default(0)->nullable(); // Salida por traslados               
            $table->decimal('cto_invfinal', 18, 2)->default(0)->nullable(); //Inventario Final
           
            $table->decimal('cto_invinicial_total', 18, 2)->default(0)->nullable(); //Inventario Inicial
            $table->decimal('cto_compralote_total', 18, 2)->default(0)->nullable(); // Compra del lote
            $table->decimal('cto_alistamiento_total', 18, 2)->default(0)->nullable(); //Alistamiento
            $table->decimal('cto_compensados_total', 18, 2)->default(0)->nullable(); // Compensados          
            $table->decimal('cto_trasladoing_total', 18, 2)->default(0)->nullable(); // Ingreso por traslados
            $table->decimal('cto_trasladosal_total', 18, 2)->default(0)->nullable(); // Salida por traslados
            $table->decimal('cto_invfinal_total', 18, 2)->default(0)->nullable(); //Inventario Final

            $table->decimal('costos', 18, 2)->default(0)->nullable(); // 
            $table->decimal('cto_venta_total', 18, 2)->default(0)->nullable(); // Ventas   
            $table->decimal('cto_notacredito', 18, 2)->default(0)->nullable(); // NC                        
            $table->decimal('cto_notadebito', 18, 2)->default(0)->nullable(); // ND
            $table->decimal('total_venta', 18, 2)->default(0)->nullable(); // 
            $table->decimal('utilidad', 18, 2)->default(0)->nullable(); // 
            $table->decimal('precioventa_min', 18, 2)->default(0)->nullable(); // Ventas 

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
        Schema::dropIfExists('centro_costo_products');
    }
}
