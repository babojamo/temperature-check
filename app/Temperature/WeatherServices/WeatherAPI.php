<?php
namespace App\Temperature\WeatherServices;

use App\Temperature\WeatherSystem;
use App\Temperature\Helpers\WeatherTrait as APIHandler;
use App\Temperature\TemperatureType;

class WeatherAPI extends WeatherSystem
{
    public function bind()
    {
        // Setup necessary api configuration
        $this->setBaseUrl(config('weather.weatherapi.base_url'));
        $this->setParameter("key",config('weather.weatherapi.app_id'));
        
        // Set api parameters or attributes
        $this->setParameter("q",$this->city.','.$this->country);
    }
    
    /**
     * Handle the success execution result of API Call
     */
    public function result($payload)
    {
        $result=json_decode($payload);
        $this->setTemperature($result->current->temp_c);
    }

    public function errorHandler($exception)
    {
        $error_code=$exception->getCode();
        if($error_code!=400)
            abort(422,"An unknown error occured when getting the weather temperature!");
    }
}