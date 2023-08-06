<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTriggerActualizarStockProductoDestino extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        DB::unprepared('
        CREATE TRIGGER trigger_actualizar_stock_producto_destino AFTER INSERT ON updating_transfer_details FOR EACH ROW
        BEGIN                
            
            DECLARE centrocostoDestinoId INT;

            select shop.centrocostoDestino_id INTO centrocostoDestinoId FROM updating_transfer AS shop WHERE shop.id = NEW.updating_transfer_id;
            
            UPDATE centro_costo_products
            SET stock = NEW.nuevo_stock_origen
            WHERE products_id = NEW.products_id AND centrocosto_id = centrocostoDestinoId;

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
        Schema::dropIfExists('trigger_actualizar_stock_producto_destino');
    }
}
