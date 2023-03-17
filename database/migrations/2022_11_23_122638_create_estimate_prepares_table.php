<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimatePreparesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_prepares', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->integer('estimate_id');
            $table->integer('dept_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('row_id');
            $table->string('row_index')->nullable();
            $table->string('sor_item_number')->nullable();
            $table->integer('estimate_no')->nullable();
            $table->string('item_name')->nullable();
            $table->string('other_name')->nullable();
            $table->integer('qty');
            $table->float('rate');
            $table->float('total_amount');
            $table->float('percentage_rate')->nullable();
            $table->string('operation')->nullable();
            $table->integer('created_by')->nullable();
            $table->string('comments')->nullable();
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
        Schema::dropIfExists('estimate_prepares');
    }
}
