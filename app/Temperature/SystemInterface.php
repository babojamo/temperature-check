<?php
namespace App\Temperature;

interface SystemInterface 
{
    public function setAttribute($key,$value);

    public function getAttribute($key);

    public function getFullUrl();
}