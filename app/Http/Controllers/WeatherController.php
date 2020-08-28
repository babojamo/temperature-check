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

        $resolver=new SystemResolver($country,$city);
        $resolver->handle();

        $temperature=$this->temperatureCache($resolver);
 
        return response()->json($temperature);
    }

    private function fetch(SystemResolver $resolver)
    {
        $temperature=WeatherTemperature::firstOrCreate([
            'country' => $resolver->country,
            'city' => $resolver->city,
            'kelvin' => $resolver->getKelvin(),
            'celsius' => $resolver->getCelsius(),
            'fahrenheit' => $resolver->getFahrenheit()
        ]);

        return $temperature;
    }

    private function temperatureCache(SystemResolver $resolver)
    {
        return cache()->rememberForever('_'.$resolver->getCacheKey(), function () use($resolver) {
            return $this->fetch($resolver);
        });
    }
}
