<?php
namespace App\Temperature;
use App\Temperature\Helpers\TemperatureConverter as Converter;
use App\Temperature\TemperatureType;
use App\Temperature\Contracts\WeatherInterface;

abstract class Weather implements WeatherInterface
{
    protected $default_format=TemperatureType::CELSIUS;
    protected $temperature;

    public $city;
    public $country;

    public function getTemperature()
    {
        return number_format($this->temperature,1);
    }

    public function setTemperature($temperature)
    {
        $this->temperature=$temperature;
    }

    public function setDefaultFormat(string $format)
    {
        $this->default_format=$format;
    }

    public function getDefaultFormat()
    {
        return $this->default_format;
    }
    
    public function changeFormat(string $format)
    {

        // Change also the temperature whenever the format is change
        if($format!=$this->getDefaultFormat())
        {
            $this->setTemperature(Converter::convert($this->getDefaultFormat(),$format,$this->getTemperature()));
        }

        $this->setDefaultFormat($format);

        return $this->getDefaultFormat();
    }
}