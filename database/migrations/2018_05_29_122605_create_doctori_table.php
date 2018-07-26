<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctoriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctori', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_cab');
            $table->integer('id_sala')->nullable();
            $table->json('id_specializari')->nullable();
            $table->char('prenume',55);
            $table->char('nume',35);
            $table->char('gen',1);
            $table->char('descriere',255)->nullable();
            $table->char('profesie',100)->nullable();
            $table->integer('frecventa'); //1-zilnic 2-saptamanal 3-lunar
            $table->json('orar')->nullable();
            $table->string('img_profile')->nullable();
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
        Schema::dropIfExists('doctori');
    }
}
