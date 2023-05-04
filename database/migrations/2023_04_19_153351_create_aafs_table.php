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
            $table->integer('project_no');
            $table->integer('dept_id');
            $table->string('status_id');
            $table->float('project_cost');
            $table->float('tender_cost');
            $table->integer('aafs_mother_id');
            $table->integer('aafs_sub_id');
            $table->string('project_type');
            $table->string('status');
            $table->string('completePeriod');
            $table->string('unNo');
            $table->string('goNo');
            $table->string('preaafsExp');
            $table->string('postaafsExp');
            $table->string('Fundcty');
            $table->string('exeAuthority');
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
