<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
 	protected $fillable = ['stop_id', 'caption', 'image', 'image_thumb'];
}
