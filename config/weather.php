<?php

return [
    
    'api' => [

        'openweathermap' => [

            'base_url'  =>  env('OPWM_URL',"http://api.openweathermap.org/data/2.5/weather"),
            'app_id'    =>  env('OPWM_APPID',""),
    
        ],
        'weatherapi' => [
    
            'base_url'  =>  env('WEATHER_API_URL',"http://api.weatherapi.com/v1/current.json"),
            'app_id'    =>  env('WEATHER_API_KEY',""),
    
        ],
    ],

    'default'   =>    App\Temperature\TemperatureType::CELSIUS,
    
    'sources'   =>  [
        
        App\Temperature\WeatherServices\OpenWeatherMap::class,
        App\Temperature\WeatherServices\WeatherAPI::class,

    ]

];
