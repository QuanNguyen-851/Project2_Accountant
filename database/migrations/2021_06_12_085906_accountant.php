<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Accountant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accountant', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->string('email')->unique();
            $table->string('phone',10)->unique();
            $table->string('userName')->unique();
            $table->string('passWord');
            $table->boolean('gender');
            $table->date('dateBirth');
            $table->text('address');
            $table->boolean('permission');
            $table->boolean('block');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accountant');
    }
}
