<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimateFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_flows', function (Blueprint $table) {
            $table->id();
            $table->integer('estimate_id')->references('estimate_id')->on('sor_masters');
            $table->foreignId('slm_id')->references('id')->on('sanction_limit_masters');
            $table->integer('sequence_no')->references('sequence_no')->on('sanction_roles');
            $table->foreignId('role_id')->references('id')->on('roles');
            $table->foreignId('permission_id')->references('id')->on('permissions');
            $table->foreignId('user_id')->references('id')->on('users')->nullable();
            $table->timestamp('associated_at')->nullable();
            $table->timestamp('dispatch_at')->nullable();
            $table->timestamps();
            $table->unique(['estimate_id','slm_id','sequence_no','role_id','permission_id','user_id'],'estimate_flow_role_permission_user_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estimate_flows');
    }
}
