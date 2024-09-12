<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nonsors', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->longText('item_name');
            $table->integer('unit');
            $table->double('price',10,2);
            $table->float('total_amount',10,2);
            $table->float('qty',10,2);
            $table->integer('created_by')->nullable();
            $table->integer('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nonsors');
    }
}
