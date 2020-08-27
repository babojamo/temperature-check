<?php
namespace App\Temperature;

interface SystemResolverInterface
{
    public function system();
    public function addSystem($name);
    public function getAverageTemperature():string;
    
}