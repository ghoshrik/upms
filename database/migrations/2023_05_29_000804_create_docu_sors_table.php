<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocuSorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql_docu_External')->create('docu_sors', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->integer('sor_docu_id');
            $table->string('document_type');
            $table->string('document_mime');
            $table->string('document_size');
            $table->longText('docufile');
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
        Schema::dropIfExists('docu_sors');
    }
}
