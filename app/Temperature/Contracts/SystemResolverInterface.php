<?php
namespace App\Temperature\Contracts;

use App\Temperature\WeatherSystem;

interface SystemResolverInterface
{
    public function getSystems();
    public function addSystem(WeatherSystem $weather_system);
    public function handle();
}