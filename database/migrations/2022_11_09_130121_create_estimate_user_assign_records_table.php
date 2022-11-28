<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimateUserAssignRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_user_assign_records', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('estimate_id');
            $table->bigInteger('estimate_user_type');
            $table->bigInteger('estimate_user_id');
            $table->longText('comments')->nullable();
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
        Schema::dropIfExists('estimate_user_assign_records');
    }
}
