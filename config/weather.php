<?php

return [
    
    'openweathermap' => [

        'base_url'  =>  env('OPWM_URL',""),
        'app_id'    =>  env('OPWM_APPID',""),

    ],

    'default'   =>    App\Temperature\TemperatureType::KELVIN,

    'sources'   =>  [
        
        App\Temperature\WeatherAPI\OpenWeatherMap::class,

    ]

];
