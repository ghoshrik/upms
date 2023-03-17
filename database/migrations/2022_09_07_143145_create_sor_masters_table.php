<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSorMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sor_masters', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->bigInteger('estimate_id');
            $table->longText('sorMasterDesc');
            $table->integer('status');
            $table->tinyInteger('is_verified')->default('0');
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
        Schema::dropIfExists('sor_masters');
    }
}
