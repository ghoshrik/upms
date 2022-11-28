<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('user_type');
            $table->unsignedBigInteger('office_id');
            $table->unsignedBigInteger('dept_id');
            $table->unsignedBigInteger('dist_id')->nullable();
            $table->unsignedBigInteger('In_rural')->nullable();
            //$table->foreign('user_type')->references('id')->on('users')->onDelete('cascade');
            ///$table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
            //$table->foreign('dept_id')->references('id')->on('departments')->onDelete('cascade');
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
        Schema::dropIfExists('roles');
    }
}
