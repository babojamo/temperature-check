<?php
namespace App\Temperature;

use App\Temperature\Contracts\SystemApiInterface;
use App\Temperature\Helpers\WeatherApiTrait as APIHandler;

abstract class WeatherSystem extends Weather implements SystemApiInterface
{
    use APIHandler;

    public abstract function bind();

    public function __construct($country,$city)
    {
        $this->country=$country;
        $this->city=$city;

        $this->bind();
    }

    public function getCacheKey()
    {
        return $this->country.$this->city;
    }
    
}