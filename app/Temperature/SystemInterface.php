<?php
namespace App\Temperature;

interface SystemInterface
{
    public function getTemperature();

    public function setAttribute($key,$value);

    public function getAttribute($key);

}