<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStyleViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('style_view', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('style_id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('style_id')->references('id')->on('styles');
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
        Schema::dropIfExists('style_view');
    }
}
