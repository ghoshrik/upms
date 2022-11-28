<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBlockCodeToRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->unsignedBigInteger("rural_block_code")->nullable()->after("In_rural");
            $table->unsignedBigInteger("gp_code")->nullable()->after("In_rural");
            $table->unsignedBigInteger("urban_code")->nullable()->after("In_rural");
            $table->unsignedBigInteger("ward_code")->nullable()->after("In_rural");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            //
        });
    }
}
