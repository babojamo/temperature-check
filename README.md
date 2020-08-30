## Temperature Checking

This is a simple weather temperature checking app that will be base on country, region and city

Application is built in Laravel 7 Framework 

(c) [Laravel Framework](https://github.com/laravel/laravel)

## Installation

Clone the repository and install the required packages
```
composer install
```

## Getting Started

Setup first the Weather Services API configurations located in **config/weather.php** and register an account to both services to gain **api keys**

Supported Weather Services

 - [Openweathermap](https://openweathermap.org/) 
 - [WeatherApi](https://www.weatherapi.com/)

  

## Configuration

Navigate weather configuration in config/weather.php and setup the openweathermap api or any weather services supported and provide the url and api key

```php

'api' => [

	'openweathermap' => [
	
		'base_url' => "http://api.openweathermap.org/data/2.5/weather",
		'app_id' => "key here",
		
	],
	
	'weatherapi' => [

		'base_url' => "http://api.weatherapi.com/v1/current.json",
		'app_id' => env('WEATHER_API_KEY',""),

	],
	
] ...
```

after changing the configuration make sure to apply it to the application

```php
    php artisan config:cache
```

Test the application by running

```php
    php artisan serve
```

Image Here

## Weather Services/Source

Default weather services are openweathermap and weatherapi, if you want to add a new service/source, run the command below

```php
php artisan make:weathersource {SourceName}
```

Class file will be generated in **app/Temperature/WeatherServices** folder

  

### Weather source bindings

Open a weather source class and bind the necessary configurations

```
public function bind()
{
	// Change the temperature format but this is optional
	// Application temperature format is CELSIUS
	$this->setDefaultFormat(TemperatureType::KELVIN);

	// Setup necessary api configuration
	$this->setBaseUrl(config('weather.api.openweathermap.base_url'));
	// APPID is the api key name for openweathermap service, you can change depending on your weather source provider
	$this->setParameter(
		"APPID",
		config('weather.api.openweathermap.app_id')
	);

	// Set api parameters or attributes based on the api requirements
	$this->setParameter("q",$this->city.','.$this->country);

}
```

Every weather source has different temperature format, you can specify a default format in the bindings

```
    $this->setDefaultFormat(TemperatureType::KELVIN);
```

Weather source api url and api key, set it using **setBaseUrl** method and **setParameter** method however, if the api key is required to set in headers, you can use the **addHeader(key,value)** method.

```
  	$this->setBaseUrl(config('weather.api.openweathermap.base_url'));
	$this->setParameter(
		"APPID",
		config('weather.api.openweathermap.app_id')
	);
```

### Weather Source Result
Every weather source provider has different result, you can fetch the result in **result(payload)** method and set the temperature using **setTemperature(temperature)** method 

```
    public function result($payload)
    {
	    $result=json_decode($payload);
	    $this->setTemperature($result->main->temp);
    }
```

## Error Handling
If the api execution fails you can fetch/handle the exception by overriding the **errorHandler(exception)** method and customize the error messages

```
    public function errorHandler($exception)
    {
	    $error_code=$exception->getCode();
	    if($error_code!=404 && $error_code!=401)
		    abort(422,"An unknown error occured when getting the weather temperature!");
	}
```

Recommended not to handle not found exception from weather source api since the application supports multi weather sources, whenever one of the source fails at least it can still proceed in other sources