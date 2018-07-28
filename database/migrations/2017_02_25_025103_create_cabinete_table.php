<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateCabineteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cabinets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->tinyInteger('verified')->default(0);
            $table->string('email')->unique();
            $table->string('img_profile')->nullable();
            $table->tinyInteger('type')->default(0);
            $table->tinyInteger('public')->default(0);
            $table->string('password');
            $table->string('judet');
            $table->string('tawk')->nullable();
            $table->string('numar',15)->nullable();
            $table->string('email_token');
            $table->longText('descriere')->nullable();
            $table->text('adresa')->nullable();
            $table->string('moto')->nullable();
            $table->json('program')->nullable();
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('long', 10, 8)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('cabinets');
    }
}