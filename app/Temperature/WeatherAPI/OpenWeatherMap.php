<?php
namespace App\Temperature\WeatherAPI;

use App\Temperature\WeatherSystem;
use App\Temperature\WeatherTrait as APIHandler;
use App\Temperature\TemperatureType;

class OpenWeatherMap extends WeatherSystem
{
    use APIHandler;

    public function __construct($country,$city)
    {

        $this->country=$country;
        $this->city=$city;

        $this->setDefaultFormat(TemperatureType::KELVIN);
        $this->init();
        
    }
    
    public function init()
    {
        // Setup necessary api configuration
        $this->base_url=config('weather.openweathermap.base_url');
        $this->setAttribute("APPID",config('weather.openweathermap.app_id'));
        
        // Set api parameters or attributes
        $this->setAttribute("q",$this->city.','.$this->country);
        $this->setAttribute("units","kelvin"); # Set default unit to kelvin for general conversion
    }

    public function handle()
    {
        $result=json_decode($this->executeApi());
        $this->temperature=$result->main->temp;

        return $this;
    }
}