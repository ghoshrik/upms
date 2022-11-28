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
            $table->id();
            $table->string('office_name')->unique();
            $table->longText('office_address');
            $table->integer('department_id');
            $table->bigInteger('dist_code');
            $table->bigInteger('In_area');
            $table->bigInteger('rural_block_code')->nullable();
            $table->bigInteger('gp_code')->nullable();
            $table->bigInteger('urban_code')->nullable();
            $table->bigInteger('ward_code')->nullable();
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
