<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRedtransfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redtransfs', function (Blueprint $table) {
            $table->id();
            $table->decimal('costotaller', 18,0)->nullable();
            $table->decimal('costolote', 18,0)->nullable();
            $table->decimal('costovendedor', 18,0)->nullable();
            $table->decimal('costofinanciero', 18,0)->nullable();
            $table->decimal('costotransporte', 18,0)->nullable();
            $table->decimal('costokilo', 18,0)->nullable();
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
        Schema::dropIfExists('redtransfs');
    }
}
