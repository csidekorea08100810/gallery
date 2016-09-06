<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alarm extends Model
{
    public function user()
	{
	    return $this->belongsTo('App\User');
	}

	public function article()
	{
	    return $this->belongsTo('App\Article');
	}

	public function comment()
	{
	    return $this->belongsTo('App\Comment');
	}
}
