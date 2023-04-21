<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMeatcuts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meatcuts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');           
            $table->string('name',255);
            $table->string('description',255)->nullable();
            $table->boolean('status')->parent_select()->default(true);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete("cascade");
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
        Schema::dropIfExists('meatcuts');
    }
}
