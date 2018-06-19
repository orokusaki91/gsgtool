<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id');
            $table->timestamp('start')->nullable();
            $table->timestamp('end')->nullable();
            $table->integer('number');
            $table->integer('reserve');
            $table->text('description')->nullable();
            $table->boolean('close')->default(false);
            $table->boolean('archive')->default(false);
            $table->string('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
