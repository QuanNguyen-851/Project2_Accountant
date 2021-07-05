<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Subfee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subfee', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idStudent');
            $table->foreign('idStudent')->references('id')->on('student');
            $table->text('note');
            $table->integer('fee');
            $table->string('accountant');
            $table->string('payer');
            $table->date('date');
            $table->string('class_bk');
            $table->integer('countPay');
            $table->boolean('disable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subfee');
    }
}
