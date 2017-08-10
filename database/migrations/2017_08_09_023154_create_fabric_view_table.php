<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFabricViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fabric_view', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fabric_id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('fabric_id')->references('id')->on('fabrics');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fabric_view');
    }
}
