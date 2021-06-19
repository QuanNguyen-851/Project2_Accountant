<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ClassBk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classbk', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->unsignedBigInteger('idMajor');
            $table->unsignedBigInteger('idCourse');
            $table->foreign('idMajor')->references('id')->on('major');
            $table->foreign('idCourse')->references('id')->on('course');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classbk');
    }
}
