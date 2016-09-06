<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Alarm;

class AlarmController extends Controller
{
    function check($id) {
    	$alarm = Alarm::where('deleted', false)
    					->where('id', $id)
    					->first();
    	$alarm->checked = 1;
    	$alarm->save();
    }
}
