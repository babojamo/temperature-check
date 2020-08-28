<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeatherTemperature extends Model
{
    protected $fillable=[
        'country',
        'city',
        'celsius',
        'kelvin',
        'fahrenheit'
    ];

    protected $hidden=[
        'created_at',
        'updated_at',
        'id',
    ];
}
