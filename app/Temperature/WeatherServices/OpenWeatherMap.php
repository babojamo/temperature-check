<?php
namespace App\Temperature\WeatherServices;

use App\Temperature\WeatherSystem;
use App\Temperature\Helpers\WeatherTrait as APIHandler;
use App\Temperature\TemperatureType;

class OpenWeatherMap extends WeatherSystem
{
    use APIHandler;

    public function __construct($country,$city)
    {
        $this->country=$country;
        $this->city=$city;

        
        $this->init();
        
    }
    
    public function init()
    {
        // Weather System default format is CELSIUS
        $this->setDefaultFormat(TemperatureType::KELVIN); # Change the default format to KELVIN

        // Setup necessary api configuration
        $this->base_url=config('weather.openweathermap.base_url');
        $this->setAttribute("APPID",config('weather.openweathermap.app_id'));
        
        // Set api parameters or attributes
        $this->setAttribute("q",$this->city.','.$this->country);
    }

    public function handle()
    {
        try {
            
            $result=json_decode($this->executeApi());
            $this->setTemperature($result->main->temp);

        } catch (\Throwable $error) {
            
            $erorr_code=$error->getCode();

            if($erorr_code==404 || $erorr_code==401)
                return null;
            else
                abort(422,"An unknown error occured when getting the weather temperature!");
        }

        return $this;
    }
}