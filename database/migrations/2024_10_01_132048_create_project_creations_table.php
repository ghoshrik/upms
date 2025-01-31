<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectCreationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_creations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name');
            $table->longText('site');
            $table->foreignId('department_id')
                ->references('id')
                ->on('departments');
            $table->foreignId('created_by')
                ->references('id')
                ->on('users');
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
        Schema::dropIfExists('project_creations');
    }
}
