<?php
namespace App\Temperature\WeatherServices;

use App\Temperature\WeatherSystem;

use App\Temperature\TemperatureType;

class OpenWeatherMap extends WeatherSystem
{
    public function bind()
    {
        // Weather System default format is CELSIUS
        $this->setDefaultFormat(TemperatureType::KELVIN); # Change the default format to KELVIN

        // Setup necessary api configuration
        $this->setBaseUrl(config('weather.api.openweathermap.base_url'));
        $this->setParameter("APPID",config('weather.api.openweathermap.app_id'));
        
        // Set api parameters or attributes
        $this->setParameter("q",$this->city.','.$this->country);
    }

    public function result($payload)
    {
        $result=json_decode($payload);
        $this->setTemperature($result->main->temp);
         
    }

    public function errorHandler($exception)
    {
        $error_code=$exception->getCode();
        if($error_code!=404 && $error_code!=401)
            abort(422,"An unknown error occured when getting the weather temperature!");
    }
    
}