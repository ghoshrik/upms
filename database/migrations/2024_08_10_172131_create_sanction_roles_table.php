<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanctionRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sanction_roles', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->foreignId('sanction_limit_master_id')->index()->references('id')->on('sanction_limit_masters');
            $table->tinyInteger('sequence_no')->default(0);
            $table->foreignId('role_id')->index()->references('id')->on('roles');
            $table->foreignId('permission_id')->index()->references('id')->on('permissions');

            $table->unique(['sanction_limit_master_id', 'role_id'], 'sanction_roles_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sanction_roles');
    }
}
