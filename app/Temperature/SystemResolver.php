<?php
namespace App\Temperature;

class SystemResolver extends Weather implements SystemResolverInterface
{

    protected $weather_systems=[];

    /**
     * Constructor accepts an option for initial source of weather system
     */
    public function __construct($country,$city)
    {
        $this->country=$country;
        $this->city=$city;

        $this->loadWeatherSystems();
    }

    public function loadWeatherSystems()
    {
        $this->setDefaultFormat(config('weather.default'));
        $sources=config('weather.sources');

        foreach ($sources as $source) {

            $weather=new $source($this->country,$this->city);
            $weather->setDefaultFormat($this->getDefaultFormat());

            $this->addSystem($weather);
        }

    }

    public function getCacheKey()
    {
        return $this->country.'_'.$this->city;
    }

    /**
     * Add weather system source
     * @param $weather_system
     */
    public function addSystem(SystemInterface $weather_system){

        $this->weather_systems[]=$weather_system;

    }

    public function getSystems()
    {
        return $this->weather_systems;
    }

    public function handle()
    {
        $temperature=0;

        foreach ($this->weather_systems as $weather_system) {

            $weather_system->handle();

            $temperature+=$weather_system->getTemperature();
        }

        $average_temperature=$temperature/count($this->weather_systems);

        $this->setTemperature($average_temperature);
    }
}