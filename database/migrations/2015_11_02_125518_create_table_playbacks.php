<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePlaybacks extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('playbacks', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->integer("user_id");
            $table->integer("production_id");
            $table->string("ip");
            $table->dateTime("date");
            $table->string("token",100);
            $table->boolean("validate");
            $table->bigInteger("parent");
            $table->index("token");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('playbacks');
    }

}
