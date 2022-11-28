<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSORSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_o_r_s', function (Blueprint $table) {
            $table->id();
            $table->string('Item_details');
            $table->bigInteger('department_id');
            $table->integer('dept_category_id');
            $table->integer('unit');
            // $table->enum('unit_type',['KG','CM'])
            $table->longText('description');
            $table->float('cost');
            $table->string('version');
            $table->date('effect_from');
            $table->date('effect_to')->nullable();
            $table->enum('IsActive',[0,1])->default('0');
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
        Schema::dropIfExists('s_o_r_s');
    }
}
