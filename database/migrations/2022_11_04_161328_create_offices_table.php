<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offices', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->string('office_name')->unique();
            $table->string('office_code')->unique();
            $table->longText('office_address');
            $table->string('department_code');
            $table->bigInteger('dist_code');
            $table->integer('level_no')->nullable();
            $table->bigInteger('in_area')->nullable();
            $table->bigInteger('rural_block_code')->nullable();
            $table->bigInteger('gp_code')->nullable();
            $table->bigInteger('urban_code')->nullable();
            $table->bigInteger('ward_code')->nullable();
            // $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('offices');
    }
}
