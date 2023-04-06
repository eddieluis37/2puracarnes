<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSacrificiocerdosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sacrificiocerdos', function (Blueprint $table) {
            $table->id();

            $table->string('name',100)->nullable();
            $table->bigInteger('dni')->unique()->nullable();
            $table->string('address',100);
            $table->bigInteger('phone')->nullable();
            $table->string('email',90)->nullable();

            $table->decimal('transporte', 18, 2)->nullable();          
            $table->decimal('sacrificio', 18, 2)->nullable();
            $table->decimal('fomento', 18, 2)->nullable(); 
            $table->decimal('deguello', 18, 2)->nullable();                       
            $table->decimal('bascula', 18, 2)->nullable();

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
        Schema::dropIfExists('sacrificiocerdos');
    }
}
