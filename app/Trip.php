<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
	protected $fillable = ['user_id', 'name', 'start_date', 'total_km', 'cover_photo_path', 'likes'];


	public function stops()
	{
		return $this->hasMany('App\Stop');
	}
}

