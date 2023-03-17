<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id')->autoIncrement();
            $table->string('name')->default('0');
            $table->string('email')->unique()->safeEmail()->default('0');
            $table->string('username');
            $table->integer('emp_id');
            $table->string('emp_name');
            $table->integer('designation_id')->default('0');
            $table->integer('department_id')->default('0');
            $table->integer('office_id')->default('0');
            $table->integer('user_type');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('mobile')->default('0');
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
