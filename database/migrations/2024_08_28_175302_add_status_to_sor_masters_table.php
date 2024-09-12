<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToSorMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sor_masters', function (Blueprint $table) {
            $table->foreignId('dept_id')->constrained('departments');
            $table->string('part_no');
            $table->timestamp('approved_at')->nullable();
            $table->integer('associated_with')->nullable();
            $table->enum('status',['draft','forward','approved'])->default('draft');
            $table->integer('created_by',5);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sor_masters', function (Blueprint $table) {
            $table->dropIfExists('sor_masters.status');
        });
    }
}
