<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeatherTemperature extends Model
{
    protected $fillable=[
        'country',
        'city',
        'format',
        'temperature',
        'date'
    ];

    protected $hidden=[
        'created_at',
        'updated_at',
        'id',
    ];
}
