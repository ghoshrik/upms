<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->foreignId('project_creation_id')
                ->references('id')
                ->on('project_creations');
            $table->foreignId('department_id')
                ->references('id')
                ->on('departments');
            $table->foreignId('created_by')
                ->references('id')
                ->on('users');
            $table->foreignId('approved_by')->nullable()
                ->references('id')
                ->on('users');
            $table->dateTime('approved_at')->nullable();
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
        Schema::dropIfExists('plans');
    }
}
