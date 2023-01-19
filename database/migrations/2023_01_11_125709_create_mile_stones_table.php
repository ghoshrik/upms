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
            $table->bigInteger('project_id');
            // $table->longText('description')->nullable();
            $table->string('milestone_name');
            $table->string('weight');
            $table->string('unit_type');
            $table->string('cost');
            // $table->foreign('project_id')->references('id')->on('sor_masters')->onDelete('cascade');
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
