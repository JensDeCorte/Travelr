<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stop extends Model
{
	protected $fillable = ['name', 'description', 'trip_id', 'views', 'deleted', 'likes', 'arrival_time'];


	public function media()
	{
		return $this->hasMany('App\Media');
	}

	public function location()
	{
		return $this->hasMany('App\Location');
	}
}