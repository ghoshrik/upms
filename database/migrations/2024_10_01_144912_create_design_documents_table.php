<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesignDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('design_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->foreignId('design_id')
                ->references('id')
                ->on('designs');
            $table->foreignId('document_type_id')
                ->references('id')
                ->on('document_types');
            $table->foreignId('project_creation_id')
                ->references('id')
                ->on('project_creations');
            $table->foreignId('department_id')
                ->references('id')
                ->on('departments');
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
        Schema::dropIfExists('design_documents');
    }
}
