<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesposteresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('desposteres', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('users_id')->nullable();
            $table->foreign('users_id')->references('id')->on('users');

        //   $table->foreignId('users_id')->constrained('users_id');

         /*    $table->unsignedBigInteger('beneficiors_desposters_id')->nullable();
            $table->foreign('beneficiors_desposters_id')->references('id')->on('beneficiors_desposters'); */
            
            $table->unsignedBigInteger('beneficiores_id')->nullable();
            $table->foreign('beneficiores_id')->references('id')->on('beneficiores');

        /* $table->unsignedBigInteger('fichatecnicas_id')->nullable();
            $table->foreign('fichatecnicas_id')->references('id')->on('fichatecnicas');*/

            $table->unsignedBigInteger('products_id')->nullable();
            $table->foreign('products_id')->references('id')->on('products');

            $table->decimal('peso', 18, 2)->nullable();
            $table->decimal('porcdesposte', 18, 2)->nullable();
            $table->decimal('costo', 18, 2)->nullable();                     
            $table->decimal('precio', 18, 2)->nullable();
            $table->decimal('totalventa', 18,2)->nullable();
            $table->decimal('total', 18, 2)->nullable();
            $table->decimal('porcventa', 18, 2)->nullable();
            $table->string('porcutilidad', 18, 2)->nullable();
            $table->enum('status',['VALID','CANCELED'])->default('VALID');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('desposteres');
    }
}
