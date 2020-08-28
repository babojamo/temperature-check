<?php
namespace App\Temperature;

use App\Temperature\TemperatureType;

interface WeatherInterface
{
    /**
     * Get the default temperature
     */
    public function getTemperature();
    
    public function setTemperature($temperature);

    public function setDefaultFormat(string $format);

    public function getDefaultFormat();

    public function getTemperatures();

    /**
     * Get the different temperature types
     */
    public function getFahrenheit();
    public function getKelvin();
    public function getCelsius();
}