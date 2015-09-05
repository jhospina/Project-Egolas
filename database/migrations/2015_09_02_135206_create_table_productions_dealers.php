<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProductionsDealers extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('productions_dealers', function (Blueprint $table) {
            $table->integer("dealer_id");
            $table->string("production_id");
            $table->string("state", 2);
            $table->string("url");
            $table->text("content");
            $table->string("languages");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('productions_dealers');
    }

}
