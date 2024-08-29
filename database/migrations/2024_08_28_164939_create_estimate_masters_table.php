<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimateMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_masters', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->foreignId('estimate_id')->constrained('estimate_id');
            $table->longText('sorMasterDesc');
            $table->enum('status',['draft','forward','new'])->default('new');
            $table->foreignId('department_id')->constrained('departments');
            $table->string('part_no');
            $table->integer('associated_with');
            $table->timestamp('approved_at')->nullable();
            $table->integer('created_by');
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
        Schema::dropIfExists('estimate_masters');
    }
}
