<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAAFSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_a_f_s', function (Blueprint $table) {
            $table->id();
            $table->string('project_id');
            $table->string('Go_id');
            $table->date('go_date');
            $table->string('support_data')->nullable();
            $table->tinyIncrements('status')->default('0');
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
        Schema::dropIfExists('a_a_f_s');
    }
}
