<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLogChapterVideoId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_chapter_video_id', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("chapter_id");
            $table->string("video_id");
            $table->datetime("date");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::drop('log_chapter_video_id');
    }
}
