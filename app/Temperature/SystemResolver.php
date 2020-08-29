<?php
namespace App\Temperature;

use App\Temperature\Contracts\SystemResolverInterface;

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
            $this->addSystem($weather);

        }

    }

    public function getCacheKey()
    {
        return $this->country.'_'.$this->city.now()->format("Ymd");
    }

    /**
     * Add weather system source
     * @param $weather_system
     */
    public function addSystem(WeatherSystem $weather_system){

        $this->weather_systems[]=$weather_system;

    }

    public function getSystems()
    {
        return $this->weather_systems;
    }

    public function handle()
    {
        $temperature=0;
        $counter=0;

        foreach ($this->weather_systems as $weather_system) {
            
            if($weather_system->executeApi())
            {
                $counter++;

                $weather_system->changeFormat($this->getDefaultFormat()); # Change to general temperature format
                $temperature+=$weather_system->getTemperature();

            }
            
            \Log::info(\get_class($weather_system).':'.$weather_system->getTemperature());
            
        }

        if(!$counter)
            abort(404,'City/Country could not be found!');
        if($counter>1)
            $temperature=$temperature/count($this->weather_systems);

        $this->setTemperature($temperature);
    }
}