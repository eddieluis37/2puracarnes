<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTriggerActualizarStockProductoOrigen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
       DB::unprepared('
            CREATE TRIGGER trigger_actualizar_stock_producto_origen AFTER INSERT ON updating_transfer FOR EACH ROW
            BEGIN                          
                UPDATE centro_costo_products
                SET stock = NEW.nuevo_stock 
                WHERE products_id = NEW.producto_id AND centrocosto_id = NEW.centrocostoOrigen_id;
            END
        ');
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trigger_actualizar_stock_producto_destino');
    }
    
}
