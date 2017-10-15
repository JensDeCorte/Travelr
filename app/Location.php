<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
	protected $fillable = ['country_code', 'name', 'city', 'province', 'country', 'time_zone', 'lat', 'long'];
}
