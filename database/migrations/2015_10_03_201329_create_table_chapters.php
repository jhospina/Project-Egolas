<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableChapters extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('chapters', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("production_id");
            $table->text("video")->unique();
            $table->string("languages");
            $table->string("subtitles")->nullable();
            $table->string("quality", 2);
            $table->string("type", 2);
            $table->string("state", 2);
            $table->integer("videocloud_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('chapters');
    }

}
