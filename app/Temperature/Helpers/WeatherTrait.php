<?php
namespace App\Temperature\Helpers;

use GuzzleHttp\Client;

trait WeatherTrait
{
    /**
     * Handles the temperature fetching form weather API
     */
    public function executeApi()
    {
        $client = new Client();
        $response = $client->request('GET', $this->getFullUrl());
        
        return $response->getBody()->getContents();
    }
}