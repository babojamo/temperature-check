<?php
namespace App\Temperature\WeatherServices;

use App\Temperature\WeatherSystem;
use App\Temperature\TemperatureType;

class WeatherSource extends WeatherSystem
{
    /**
     * 
     * Setup necessary configurations for api
     * 
     * API Configurations
     * API Parameters
     * Temperature Default Format
     * 
     */
    public function bind()
    {

    }

    /**
     * Result handler after the successfull api execution
     * @param $payload Usually JSON or depends on the api used
     */
    public function result($payload)
    {
        $this->setTemperature($payload->temperature);
    }
    
}