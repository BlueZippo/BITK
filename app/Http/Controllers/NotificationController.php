<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Notification;

class NotificationController extends Controller
{
    public function read()
    {
    	$userid = auth()->id();

    	$user = User::find($userid);

    	foreach($user->notifications as $notify)
    	{
    		$notify->status = 1;

    		$notify->save();
    	}

    	return ['success' => 1];
    }
}
