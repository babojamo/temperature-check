<?php
namespace App\Temperature;

interface SystemResolverInterface
{
    public function getSystems();
    public function addSystem(SystemInterface $weather_system);
    public function handle();
}