<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarriagesorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carriagesors', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->longText('description');
            $table->integer('unit_id');
            $table->string('zone');
            $table->integer('start_distance')->default(0);
            $table->integer('upto_distance')->default(0);
            $table->float('cost');
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
        Schema::dropIfExists('carriagesors');
    }
}
