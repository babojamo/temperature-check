<?php
namespace App\Temperature;

use App\Temperature\Contracts\SystemInterface;


abstract class WeatherSystem extends Weather implements SystemInterface
{
    protected $base_url;

    protected $attributes=[];

    public function getCacheKey()
    {
        return $this->country.$this->city;
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
        return $this->base_url.'?'.http_build_query($this->attributes);
    }

    public abstract function handle();
}