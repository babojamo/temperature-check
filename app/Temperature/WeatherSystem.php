<?php
namespace App\Temperature;

abstract class WeatherSystem implements SystemInterface
{
    protected $base_url;

    protected $attributes=[];

    protected $temperature;
 
    public function getTemperature()
    {
        return $this->temperature;
    }

    public function setAttribute($key,$value)
    {
        $this->attributes[$key]=$value;
    }

    public function getAttribute($key)
    {
        return $this->attributes[$key];
    }

    public function getFullUrl()
    {
        return $this->url.'?'.http_build_query($this->attributes);
    }

    public abstract function handle();
}