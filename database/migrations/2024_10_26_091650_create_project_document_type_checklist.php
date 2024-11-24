<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('project_document_type_checklist', function (Blueprint $table) {
            $table->foreignId('project_creation_id')->references('id')->on('project_creations');
            $table->foreignId('document_type_id')->references('id')->on('document_types');
            $table->unique(['project_creation_id', 'document_type_id'], 'project_document_type_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_document_type_checklist');
    }
};
