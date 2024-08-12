<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolumeMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master.volume_masters', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->string('volume_name');
            $table->enum('status', ['active', 'inactive'])->default('inactive');
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
        Schema::dropIfExists('master.volume_masters');
    }
}