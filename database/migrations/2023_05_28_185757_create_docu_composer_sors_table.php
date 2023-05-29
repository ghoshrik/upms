<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocuComposerSorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('pgsql_docu_External')->create('docu_composer_sors', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->unsignedBigInteger('composer_sor_id');
            $table->string('document_type');
            $table->string('document_mime');
            $table->string('document_size');
            $table->longText('docufile');
            // $table->foreign('composer_sor_id')->references('id')->on('composer_sors')->onDelete('cascade');
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
        Schema::dropIfExists('docu_composer_sors');
    }
}
