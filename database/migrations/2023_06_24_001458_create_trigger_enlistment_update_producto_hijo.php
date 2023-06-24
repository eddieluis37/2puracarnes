<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTriggerEnlistmentUpdateProductoHijo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER trigger_enlistment_update_producto_hijo AFTER INSERT ON shopping_enlistment_details FOR EACH ROW
            BEGIN
                UPDATE products
                SET stock = NEW.newstock
                WHERE id = NEW.products_id;
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
        Schema::dropIfExists('trigger_enlistment_update_producto_hijo');
    }
}
