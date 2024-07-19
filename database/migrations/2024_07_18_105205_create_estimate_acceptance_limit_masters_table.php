<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimateAcceptanceLimitMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_acceptance_limit_masters', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->foreignId('department_id');
            $table->foreignId('level_id');
            $table->float('min_amount');
            $table->float('max_amount');
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
        Schema::dropIfExists('estimate_acceptance_limit_masters');
    }
}