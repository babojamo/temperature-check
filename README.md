## Temperature Checking
This is a simple weather temperature checking app that will be base on country and city


(c) Laravel Framework

## Getting Started
run development server

```
php artisan serve
```

## Installation
clone the repository and install required packages
```
composer install
```

## Configuration
Navigate weather configuration in config/weather.php and setup the openweathermap api or any weather source you used, provide the url and api key
```php

'api' => [

    'openweathermap' => [

        'base_url'  =>  "url here",
        'app_id'    =>  "key here",

    ],
] ...

```
after changing the configuration make sure to apply it to the application
## Weather Sources
Default weather source is openweathermap, if you want to add a new weather source, run the command below

```php
php artisan make:weathersource {SourceName}
```
Class file will be generated in **app/Temperature/WeatherServices** folder

### Weather source bindings
Open a weather source class and bind the configurations, necessary configurations 
```
public function bind()
{
    // Change the temperature format but this is optional
    // Application temperature format is CELSIUS
    $this->setDefaultFormat(TemperatureType::KELVIN);

    // Setup necessary api configuration
    $this->setBaseUrl(config('weather.api.openweathermap.base_url'));
    $this->setParameter(
        "APPID",
        config('weather.api.openweathermap.app_id')
    );
        
    // Set api parameters or attributes based on the api requirements
    $this->setParameter("q",$this->city.','.$this->country);
}
```

## Error Handling