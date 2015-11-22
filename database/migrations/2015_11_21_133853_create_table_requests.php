<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRequests extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('requests', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("user_id");
            $table->integer("production_id")->nullable();
            $table->integer("queue_id");
            $table->dateTime("date");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('requests');
    }

}
