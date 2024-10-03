<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStandredDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('standred_documents', function (Blueprint $table) {
            $table->increments('id')->autoIncrement();
            $table->string('title');
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade')->onUpdate('cascade');
            $table->longText('upload_file');
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
        Schema::dropIfExists('standred_documents');
    }
}
