<?php
namespace App\Temperature\Contracts;

interface WeatherInterface
{
    public function getTemperature();
    
    public function setTemperature($temperature);

    public function setDefaultFormat(string $format);

    public function getDefaultFormat();
    
    public function changeFormat(string $format);
}