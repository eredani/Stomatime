<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramariTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programari', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_cab');
            $table->integer('id_doctor');
            $table->integer('id_client');
            $table->integer('id_sala');
            $table->integer('id_servicu');
            $table->integer('status'); //acceptat - neacceptat
            $table->dateTime('data');
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
        Schema::dropIfExists('programari');
    }
}
