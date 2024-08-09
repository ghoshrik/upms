<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanctionsRolesPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sanctions_roles_permissions', function (Blueprint $table) {
            $table->foreignId('sanction_id')->index()->references('id')->on('estimate_acceptance_limit_masters');
            $table->tinyInteger('sequence_no')->default(0);
            $table->foreignId('role_id')->index()->references('id')->on('roles');
            $table->foreignId('permission_id')->index()->references('id')->on('permissions');

            $table->unique(['sanction_id', 'role_id', 'permission_id'], 'sanction_role_permission_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sanctions_roles_permissions');
    }
}
