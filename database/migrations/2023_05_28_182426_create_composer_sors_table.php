<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComposerSorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('composer_sors', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->integer('dept_category_id');
            $table->integer('sor_itemno_parent_id');
            $table->string('sor_itemno_child');
            $table->longText('description');
            $table->integer('unit_id');
            $table->float('rate');
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
        Schema::dropIfExists('composer_sors');
    }
}
