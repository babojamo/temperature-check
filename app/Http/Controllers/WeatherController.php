<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Temperature\SystemResolver;
use App\WeatherTemperature;

class WeatherController extends Controller
{
    public function getTemperature(Request $request)
    {
        $this->validate($request,[
            'city' => 'required',
            'country' => 'required'
        ]);
        
        $country=$request->country;
        $city=$request->city;

        // Instantiate system resolver for all weather sources
        $resolver=new SystemResolver($country,$city);

        // Get the temperature location from cache
        $temperature=$this->getTemperatureCache($resolver);

        // If there is no cache, get it from weather sources
        if(!$temperature)
        {
            $resolver->handle();
            $temperature=$this->setTemperatureCache($resolver);
        }

        return response()->json($temperature);
    }

    /**
     * Fetch the location temperature from database
     * 
     */
    private function fetch(SystemResolver $resolver)
    {
        $temperature=WeatherTemperature::firstOrCreate([
            'country' => $resolver->country,
            'city' => $resolver->city,
            'temperature' => $resolver->getTemperature(),
            'format'=>$resolver->getDefaultFormat(),
            'date'=>now()
        ]);

        return $temperature;
    }

    /**
     * Get the location temperature from cache
     */
    private function getTemperatureCache(SystemResolver $resolver)
    {
        return cache()->get($resolver->getCacheKey());
    }

    /**
     * Set the weather location temperature to cache
     */
    private function setTemperatureCache(SystemResolver $resolver)
    {
        return cache()->rememberForever($resolver->getCacheKey(), function () use($resolver) {
            return $this->fetch($resolver);
        });
    }
}
