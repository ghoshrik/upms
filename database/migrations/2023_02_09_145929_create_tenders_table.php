<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('project_no')->unique();
            $table->string('project_title');
            $table->longText('description');
            $table->enum('status',['0','1'])->default('0');
            $table->timestamps();
        });

        /*
        tender create => project_no,project_description,tender_ref_no,tender_start_date,tender_end_date,lower_bider_amt,higher_bider_amt
        tender edit => same
        tender file verification higher stage to lower stage level verification

        1) MileStone creating time by mistake one level missing, this time tree show on view page add this level any level add this level.
        2)


        */



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenders');
    }
}
