<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePayments extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments("id");
            $table->integer("user_id");
            $table->string("method", 20);
            $table->float("mount");
            $table->integer("quantity",3);
            $table->string("transaction_id");
            $table->string("ip");
            $table->string("user_agent");
            $table->dateTime("date");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('payments');
    }

}
