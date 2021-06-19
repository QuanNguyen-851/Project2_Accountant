<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Student extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('gender');
            $table->date('dateBirth');
            $table->string('email')->unique();
            $table->string('phone',10)->unique();
            $table->text('address');
            $table->integer('fee');
            $table->unsignedBigInteger('idClass');
            $table->foreign('idClass')->references('id')->on('classbk');
            $table->unsignedBigInteger('idStudentShip');
            $table->foreign('idStudentShip')->references('id')->on('scholarship');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student');
    }
}
