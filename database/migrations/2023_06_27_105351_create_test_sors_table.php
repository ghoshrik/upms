<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestSorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_sors', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->string('Item_details')->unique();
            $table->integer('department_id');
            $table->integer('dept_category_id');
            $table->integer('unit');
            $table->integer('unit_id');
            $table->longText('description');
            $table->float('cost');
            $table->string('version');
            $table->date('effect_form');
            $table->date('effect_to')->nullable();
            $table->enum('is_active',[0,1])->default(0);
            $table->enum('is_approved',[0,1])->default(0);
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
        Schema::dropIfExists('test_sors');
    }
}
