<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemStyleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('item_style', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('style_id');
            $table->integer('item_id');
            $table->timestamps();
            $table->foreign('style_id')->references('id')->on('styles');
            $table->foreign('item_id')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_style');
    }
}
