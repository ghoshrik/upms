<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherOfficeAssignRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_office_assign_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('request_from')->default(0);
            $table->integer('user_id')->default(0);
            $table->integer('office_id')->default(0);
            $table->string('roles');
            $table->tinyInteger('status')->default(0);
            $table->string('remarks')->default(0);
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
        Schema::dropIfExists('other_office_assign_requests');
    }
}
