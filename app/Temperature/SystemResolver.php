<?php
namespace App\Temperature;

class SystemResolver implements SystemResolverInterface
{

    protected $weather_systems=[];
    
    
    /**
     * Constructor accepts an option for initial source of weather system
     */
    public function __construct(SystemInterface $system=null)
    {
        if($system)
            $this->addSystem($system);
    }

    /**
     * Add weather system source
     * @param $weather_system
     */
    public function addSystem(SystemInterface $weather_system){
        $this->weather_systems[]=$weather_system;
    }


    /**
     * Get the average temperature from all weather system sources
     * @param $average
     */
    public function getAverageTemperature()
    {
        $sum_temperature=0;

        array_map(function($system){
            
            $sum_temperature+=$system->getTemperature();

        },$this->weather_systems);
        
        $average=$sum_temperature/count($this->weather_systems);

        return $average;
    }
}