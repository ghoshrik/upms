<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUploadFileSizeToStandredDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('standred_documents', function (Blueprint $table) {
            $table->unsignedBigInteger('upload_file_size')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('standred_documents', function (Blueprint $table) {
            $table->dropColumn('upload_file_size');
        });
    }
}
