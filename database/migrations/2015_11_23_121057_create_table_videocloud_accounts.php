<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVideocloudAccounts extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('videocloud_accounts', function (Blueprint $table) {
            $table->increments("id");
            $table->string("email")->unique;
            $table->string("token");
            $table->string("player");
            $table->datetime("date");
            $table->datetime("end");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('videocloud_accounts');
    }

}
