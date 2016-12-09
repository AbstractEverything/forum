<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('forum_id')->unsigned();
            $table->integer('latest_reply_id')->nullable()->unsigned();
            $table->string('title');
            $table->string('body');
            $table->boolean('pinned')->default(false);
            $table->boolean('closed')->default(false);
            $table->integer('views')->default(0);
            $table->boolean('moved')->default(false);
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('posts');
    }
}
