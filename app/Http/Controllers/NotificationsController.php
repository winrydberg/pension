<?php

namespace App\Http\Controllers;

use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function getNotifications(){
        $unreads = UserNotification::where('user_id', Auth::user()->id)->where('read', false)->get();
        $reads = UserNotification::where('user_id', Auth::user()->id)->where('read', true)->get();
        return view('notifications', compact('unreads', 'reads'));
    }
}
