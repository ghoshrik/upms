<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMileStonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mile_stones', function (Blueprint $table) {
            $table->id();
            $table->integer('index');
            $table->integer('parent_id')->nullable();
            $table->unsignedBigInteger('project_id');
            // $table->longText('description')->nullable();
            $table->string('m1');
            $table->string('m2');
            $table->string('m3');
            $table->string('m4');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
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
        Schema::dropIfExists('mile_stones');
    }
}
