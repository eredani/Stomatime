<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MedicStars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * */
    public function up()
    {
        Schema::create('starMedic', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_cab');
            $table->integer('id_medic');
            $table->integer('id_client');
            $table->integer('scor');
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
        Schema::dropIfExists('starMedic');
    }
}
