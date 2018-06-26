<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('name')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('nickname')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('logo')->nullable();
            $table->date('general')->nullable();
            $table->string('service_number')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->integer('canton')->nullable();
            $table->boolean('official_address')->default(false);
            $table->boolean('post_address')->default(false);
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('contact')->nullable();
            $table->text('info')->nullable();
            $table->string('ahv')->nullable();
            $table->string('apartment')->nullable();
            $table->integer('marital_status')->nullable();
            $table->date('wedding_date')->nullable();
            $table->string('nationality')->nullable();
            $table->integer('work_permit')->nullable();
            $table->date('work_permit_date')->nullable();
            $table->integer('acc_type')->nullable();
            $table->string('iban')->nullable();
            $table->string('number_bank')->nullable();
            $table->string('number_post')->nullable();
            $table->integer('current_job')->nullable();
            $table->string('spoken_language')->nullable();
            $table->integer('auto')->nullable();
            $table->integer('driving_license')->nullable();
            $table->string('height')->nullable();
            $table->integer('trousers_size')->nullable();
            $table->integer('t_shirt_size')->nullable();
            $table->string('shoe_size')->nullable();
            $table->string('users')->nullable();
            $table->boolean('archived')->default(false);
            $table->boolean('main_company')->default(false);
            $table->string('main_company_id')->nullable();
            $table->integer('staff_type')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
