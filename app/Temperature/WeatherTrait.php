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
        try {

            $client = new Client();
            $response = $client->request('GET', $this->getFullUrl());
            
            return $response->getBody()->getContents();

        } catch (\Throwable $error) {

            throw new \Exception($error->getMessage());

        }
        
    }
}