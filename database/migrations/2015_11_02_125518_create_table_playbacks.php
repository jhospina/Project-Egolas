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
            $table->string("user_agent")->nullable();
            $table->dateTime("date");
            $table->string("token",100)->unique();
            $table->boolean("validate");
            $table->bigInteger("parent");
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
