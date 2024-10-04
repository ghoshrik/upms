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

        Schema::create('projects_users', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->references('id')
                ->on('users');
            $table->foreignId('project_creation_id')
                ->references('id')
                ->on('project_creations');

            $table->primary(['user_id', 'project_creation_id']);
            
            $table->dateTime('assigned_at')->nullable();
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
