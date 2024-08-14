<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->references('id')->on('departments');
            $table->foreignId('volume_id')->references('id')->on('master.volume_masters');
            $table->string('dept_category_name');
            $table->integer('target_pages');
            $table->timestamps();
            $table->unique(['department_id','volume_id','dept_category_name'],'department_categories_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('department_categories');
    }
}
