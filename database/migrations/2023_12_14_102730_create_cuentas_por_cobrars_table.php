<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuentasPorCobrarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuentas_por_cobrars', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('parametrocontable_id')->nullable();           
            $table->foreign('parametrocontable_id')->references('id')->on('parametrocontables');

            $table->unsignedBigInteger('third_id')->nullable();           
            $table->foreign('third_id')->references('id')->on('thirds');
            



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
        Schema::dropIfExists('cuentas_por_cobrars');
    }
}
