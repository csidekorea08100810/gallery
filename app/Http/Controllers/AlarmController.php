<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

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

    function alarm_check($user_id) {
    	$user = User::find(auth()->user()->id);
    	$user->alarm_check = 1;
    	$user->save();
    }

    function read_all_alarm($user_id) {
        $alarms = Alarm::where('deleted', false)
                        ->where('user_id', $user_id)
                        ->get();
        foreach ($alarms as $alarm) {
            $alarm->checked = 1;
            $alarm->save();
        }
    }
}
