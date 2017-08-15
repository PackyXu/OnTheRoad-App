<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    //
    public function index ()
    {
        $user = Auth::user();
        return view('notifications.index',compact('user'));
    }
}
