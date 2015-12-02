<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableQueueProductionsAutoupdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('queue_productions_autoupdate', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("production_id")->nullable();
            $table->string("name");
            $table->string('link')->unique();
            $table->timestamp('date_creation');
            $table->timestamp('date_processed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('queue_productions_autoupdate');
    }
}
