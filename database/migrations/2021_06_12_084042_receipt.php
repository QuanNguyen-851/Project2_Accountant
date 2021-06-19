<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Receipt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idStudent');
            $table->foreign('idStudent')->references('id')->on('student');
            $table->unsignedBigInteger('idMethod');
            $table->foreign('idMethod')->references('id')->on('payment');
            $table->text('note');
            $table->integer('fee');
            $table->string('accountant');
            $table->string('payer');
            $table->date('date');
            $table->string('class_bk');
            $table->integer('countPay');
            $table->string('method');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fee');
    }
}
