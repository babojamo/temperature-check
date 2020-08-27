<?php
namespace App\Temperature\WeatherAPI;

use App\Temperature\WeatherSystem;
use App\Temperature\WeatherTrait as APIHandler;

class OpenWeatherMap extends WeatherSystem
{
    use APIHandler;

    public function __construct($country,$city)
    {

        // Setup necessary api configuration
        $this->base_url=config('weather.openweathermap.base_url');
        $this->setAttribute("APPID",config('weather.openweathermap.app_id'));
        
        // Set api parameters or attributes
        $this->setAttribute("q",$city.','.$country);
        $this->setAttribute("units","kelvin"); # Set default unit to kelvin for general conversion

    }

    public function handle()
    {
        $this->executeApi();
    }
}