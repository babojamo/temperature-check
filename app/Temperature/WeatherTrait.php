<?php
namespace App\Temperature;

use GuzzleHttp\Client;

trait WeatherTrait
{
    /**
     * Handles the temperature fetching form weather API
     */
    public function executeApi()
    {
        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', $this->getFullUrl());

        dump($res);
    }
}