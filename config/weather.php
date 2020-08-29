<?php

return [
    
    'openweathermap' => [

        'base_url'  =>  env('OPWM_URL',""),
        'app_id'    =>  env('OPWM_APPID',""),

    ],
    'weatherapi' => [

        'base_url'  =>  env('WEATHER_API_URL',""),
        'app_id'    =>  env('WEATHER_API_KEY',""),

    ],

    'default'   =>    App\Temperature\TemperatureType::CELSIUS,

    'sources'   =>  [
        
        App\Temperature\WeatherServices\OpenWeatherMap::class,
        App\Temperature\WeatherServices\WeatherAPI::class,

    ]

];
