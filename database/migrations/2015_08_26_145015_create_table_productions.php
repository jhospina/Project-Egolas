<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProductions extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('productions', function (Blueprint $table) {
            $table->increments('id');
            $table->string("title");
            $table->string('title_original');
            $table->string("slug");
            $table->text('description')->nullable();
            $table->string('state',2)->default("IW");
            $table->string("year", 4)->nullable();
            $table->string("rating_rel", 5)->nullable();
            $table->string("duration", 10)->nullable();
            $table->string("image")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('productions');
    }

}
