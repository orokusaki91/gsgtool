<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTheftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thefts', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('firstname');
            $table->string('lastname');
            $table->date('birthdate');
            $table->string('nationality');
            $table->integer('gender');
            $table->string('goods');
            $table->string('price');
            $table->boolean('damaged')->default(false);
            $table->text('description');
            $table->text('documents')->nullable();
            $table->integer('user_id');
            $table->integer('client_id');
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
        Schema::dropIfExists('thefts');
    }
}
