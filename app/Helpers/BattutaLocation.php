<?php
namespace App\Helpers;

use GuzzleHttp\Client;

class BattutaLocation
{

    // This is a demo only, this must be secured if deployed in production
    protected $base_url="http://battuta.medunes.net/api";
    protected $api_key="ea2f520166510145a37f0dedaaed1624";
    protected $url;
    protected $api_result;


    /**
     * Get countries
     * @param $resultHandler Optionally get the result via handler
     */
    public function getCountries($resultHandler=null)
    {
        $this->url=$this->base_url."/country/all/?key={$this->api_key}";
        return $this->handle($resultHandler);
    }

    /**
     * Get Regions
     * @param $country_code Must search the city in specific country code
     * @param $resultHandler Optionally get the result via handler
     */
    public function getRegions($country_code,$resultHandler=null)
    {
        $this->url=$this->base_url."/region/{$country_code}/all/?key={$this->api_key}";
        return $this->handle($resultHandler);
    }


    /**
     * Get Cities
     * @param $country_code Must search the city in specific country code
     * @param $region City Must search the city in specific region
     * @param $resultHandler Optionally get the result via handler
     */
    public function getCities($country_code,$region,$resultHandler=null)
    {
        $this->url=$this->base_url."/city/{$country_code}/search/?key={$this->api_key}&region={$region}";
        return $this->handle($resultHandler);
    }

    protected function handle($closure=null)
    {
        try {

            $client = new Client();
            $response = $client->request('GET',$this->url);

            $this->api_result = $response->getBody()->getContents();

            if($closure)
            {
                $closure($this->getApiResult());
            }
            else
            {
                return $this->getApiResult();
            }

        } catch (\Throwable $th) {

            throw new \Exception("Location Searching Error: ".$th->getMessage());

        }
    }

    public function getApiResult()
    {
        return $this->api_result;
    }
}