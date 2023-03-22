<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAafsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aafs', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->integer('project_id');
            $table->integer('Go_id');
            $table->longText('support_data');
            $table->tinyInteger('status')->default('0');
            $table->date('go_date');
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
        Schema::dropIfExists('aafs');
    }
}
