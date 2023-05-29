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
            $table->integer('rate_id');
            $table->integer('row_id');
            $table->string('row_index')->nullable();
            $table->integer('dept_id');
            $table->string('label')->default(0);
            $table->integer('unit')->default(0);
            $table->float('value');
            $table->string('operation')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('created_by');
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
