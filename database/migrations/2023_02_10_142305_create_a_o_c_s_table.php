<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAOCSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_o_c_s', function (Blueprint $table) {
            $table->id();
            $table->integer('project_no');
            $table->string('tender_id');
            $table->string('tender_title');
            $table->date('publish_date');
            $table->date('close_date');
            $table->string('bidder_name');
            $table->string('tender_category');
            // $table->
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
        Schema::dropIfExists('a_o_c_s');
    }
}
