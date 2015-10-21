<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProductionRatings extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('production_ratings', function (Blueprint $table) {
            $table->integer("user_id");
            $table->integer("production_id");
            $table->float("rating");
            $table->dateTime("date");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('production_ratings');
    }

}
