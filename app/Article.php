<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
	public function user()
	{
	    return $this->hasOne('App\User', 'name', 'writer_key');
	}

    public function comments() {
    	return $this->hasMany('App\Comment');
    }

    public function alarms()
    {
        return $this->hasMany('App\Alarm');
    }
}
