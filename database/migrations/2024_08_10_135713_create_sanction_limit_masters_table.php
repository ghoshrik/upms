<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanctionLimitMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sanction_limit_masters', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->integer('department_id')->index()->references('id')->on('departments');
            $table->decimal('min_amount',15,0);
            $table->decimal('max_amount',15,0)->nullable();
            $table->timestamps();
            $table->unique(['department_id','min_amount','max_amount'],'sanction_limit_master_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sanction_limit_masters');
    }
}
