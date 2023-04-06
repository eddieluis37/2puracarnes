<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrecioAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('precio_agreements', function (Blueprint $table) {
            
            $table->id();

            $table->enum('line',['HOGAR','FAMAS','HORECA','INSTITUCIONAL'])->default('HOGAR');

            $table->unsignedBigInteger('agreement_id');
            $table->foreign('agreement_id')->references('id')->on('agreements');

            $table->foreignId('product_id')->constrained();

            $table->decimal('precio',10,2)->default(0);

            $table->unsignedBigInteger('user_id')->nullable();           
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('vendedor',150)->nullable();           

            $table->decimal('descuento',10,2)->default(0);
            
            $table->decimal('valorfinal',10,2)->default(0);


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
        Schema::dropIfExists('precio_agreements');
    }
}
