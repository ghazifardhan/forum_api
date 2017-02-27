<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post', function(Blueprint $table){
            $table->increments('id');
            $table->integer('thread_id')->unsigned();
            $table->string('post');
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('thread_id')->references('id')->on('forum_thread');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
