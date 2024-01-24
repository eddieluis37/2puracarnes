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
