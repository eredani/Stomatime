<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiciiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicii', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_cab');
            $table->integer('id_specializare');
            $table->double('pret');
            $table->char('denumire',255);
            $table->integer('durata'); //in minute
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
        Schema::dropIfExists('servicii');
    }
}
