<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->string('title')->unique();
            $table->integer('parent_id')->nullable();
            $table->string('icon');
            // $table->string('slug');
            $table->string('link');
            $table->string('link_type');
            $table->string('permission')->nullable();;
            $table->integer('piority')->nullable();
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
        Schema::dropIfExists('menus');
    }
}
