<?php
namespace App\Temperature\Helpers;

use GuzzleHttp\Client;

trait WeatherApiTrait
{

    protected $base_url;

    protected $parameters = [];

    protected $headers = [];
 
    public function setParameter($key,$value)
    {
        $this->parameters[$key]=$value;
    }

    public function getParameter($key)
    {
        return $this->parameters[$key];
    }

    public function addHeader($key,$value)
    {
        return $this->headers[$key]=$value;
    }

    public function getHeaders()
    {
        return $this->headers;
    }


    public function setBaseUrl(string $url)
    {
        $this->base_url=$url;
    }

    public function getBaseUrl()
    {
        return $this->base_url;
    }

    public function getUrl()
    {
        return $this->base_url.'?'.http_build_query($this->parameters);
    }


    public function executeApi()
    {
        try {

            $client = new Client();
            $response = $client->request('GET', $this->getUrl(),$this->getHeaders());
            
            $this->result($response->getBody()->getContents());

            return true;

        } catch (\Throwable $th) {

            $this->errorHandler($th);

            return false;
        }
    }

    public function result($payload)
    {
        
    }

    public function errorHandler($exception)
    {
        throw new \Exception("Weather Temperature Error: ".$exception->getMessage());
    }
}