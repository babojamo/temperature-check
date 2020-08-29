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

        $temperature=$this->getTemperatureCache($resolver);

        if(!$temperature)
        {
            $resolver->handle();
            $temperature=$this->setTemperatureCache($resolver);
        }

        return response()->json($temperature);
    }

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

    private function getTemperatureCache(SystemResolver $resolver)
    {
        return cache()->get($resolver->getCacheKey());
    }

    private function setTemperatureCache(SystemResolver $resolver)
    {
        return cache()->rememberForever($resolver->getCacheKey(), function () use($resolver) {
            return $this->fetch($resolver);
        });
    }
}
