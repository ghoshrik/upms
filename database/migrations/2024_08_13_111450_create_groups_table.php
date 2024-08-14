<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->index()->reference('id')->on('departments');
            $table->foreignId('dept_category_id')->index()->reference('id')->on('department_categories');
            $table->string('group_name');
            $table->timestamps();
            $table->unique(['department_id','dept_category_id','group_name'],'department_category_wise_group_name_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
    }
}
