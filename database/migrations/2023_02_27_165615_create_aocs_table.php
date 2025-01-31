<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aocs', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->integer('go_id');
            $table->integer('vendor_id');
            // $table->string('go_record');
            $table->date('approved_date');
            $table->float('amount',8,2);
            $table->integer('status')->default('0');
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
        Schema::dropIfExists('aocs');
    }
}
