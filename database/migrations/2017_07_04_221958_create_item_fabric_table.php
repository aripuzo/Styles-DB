<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemFabricTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_fabric', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id');
            $table->integer('fabric_id');
            $table->timestamps();
            $table->foreign('fabric_id')->references('id')->on('fabrics');
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
        Schema::dropIfExists('item_fabric');
    }
}
