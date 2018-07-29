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
            $table->integer('numar');
            $table->integer('status')->default(0); // 1 acceptat - 0 neacceptat
            $table->date('data');
            $table->time('ora');
            $table->integer('code');
            $table->tinyInteger('confirmat')->default(0);
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
