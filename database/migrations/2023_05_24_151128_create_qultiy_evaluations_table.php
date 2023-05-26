<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQultiyEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qultiy_evaluations', function (Blueprint $table) {
            $table->id();
            $table->integer('estimate_id');
            $table->string('lable')->default(0);
            $table->string('unit')->default(0);
            $table->integer('value');
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
        Schema::dropIfExists('qultiy_evaluations');
    }
}
