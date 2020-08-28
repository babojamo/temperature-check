<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeatherTemperaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weather_temperatures', function (Blueprint $table) {
            $table->id();
            
            $table->string('city');
            $table->string('country');

            $table->double('kelvin');
            $table->double('celsius');
            $table->double('fahrenheit');

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
        Schema::dropIfExists('weather_temperatures');
    }
}
