<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimates', function (Blueprint $table) {
            $table->id();
            $table->integer('estimate_id');
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
        Schema::dropIfExists('estimates');
    }
}
