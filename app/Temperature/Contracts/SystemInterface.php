<?php
namespace App\Temperature\Contracts;

interface SystemInterface 
{
    public function setAttribute($key,$value);

    public function getAttribute($key);

    public function getFullUrl();
}