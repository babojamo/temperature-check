<?php
namespace App\Temperature;
use App\Temperature\Helpers\TemperatureConverter as Converter;
use App\Temperature\TemperatureType;

abstract class Weather implements WeatherInterface
{
    protected $default_format=TemperatureType::CELSIUS;
    protected $temperature;

    public $city;
    public $country;

    public function getTemperature()
    {
        return $this->temperature;
    }

    public function setTemperature($temperature)
    {
        $this->temperature=$temperature;
    }

    public function getFahrenheit()
    {
        if($this->default_format==TemperatureType::FAHRENHEIT)

            return $this->getTemperature();
        else

            return Converter::convert($this->default_format,TemperatureType::FAHRENHEIT,$this->getTemperature());
    }

    public function getKelvin()
    {
        if($this->default_format==TemperatureType::KELVIN)

            return $this->getTemperature();
        else

            return Converter::convert($this->default_format,TemperatureType::FAHRENHEIT,$this->getTemperature());
    }

    public function getCelsius()
    {
        if($this->default_format==TemperatureType::CELSIUS)

            return $this->getTemperature();

        else

            return Converter::convert($this->default_format,TemperatureType::CELSIUS,$this->getTemperature());
    }


    public function setDefaultFormat(string $format)
    {
        $this->default_format=$format;
    }

    public function getDefaultFormat()
    {
        return $this->default_format;
    }


    public function getTemperatures()
    {
        return [
            'kelvin' => $this->getKelvin(),
            'celsius' => $this->getCelsius(),
            'fahrenheit' => $this->getFahrenheit()
        ];
    }
    
}