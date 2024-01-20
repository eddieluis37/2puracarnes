<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTemporaryAccumulatedNotadebito extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_temporary_accumulated_notadebito', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->decimal('accumulated_quantity', 8, 2);
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
        Schema::dropIfExists('table_temporary_accumulated_notadebito');
    }
}
