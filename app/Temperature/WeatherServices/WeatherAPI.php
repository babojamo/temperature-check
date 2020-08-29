<?php
namespace App\Temperature\WeatherServices;

use App\Temperature\WeatherSystem;
use App\Temperature\Helpers\WeatherTrait as APIHandler;
use App\Temperature\TemperatureType;

class WeatherAPI extends WeatherSystem
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
        // Setup necessary api configuration
        $this->base_url=config('weather.weatherapi.base_url');
        $this->setAttribute("key",config('weather.weatherapi.app_id'));
        
        // Set api parameters or attributes
        $this->setAttribute("q",$this->city.','.$this->country);
    }

    public function handle()
    {
        try {
            
            $result=json_decode($this->executeApi());
            $this->setTemperature($result->current->temp_c);

        } catch (\Throwable $error) {
            
            $erorr_code=$error->getCode();

            if($erorr_code==400)
                return null;
            else
                abort(422,"An unknown error occured when getting the weather temperature!");
        }

        return $this;
    }
}