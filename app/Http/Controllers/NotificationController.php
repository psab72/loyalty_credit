<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Notification;

class NotificationController extends Controller
{
    //
    public function index(Notification $notification)
    {
        $notifications = $notification->where('merchant_id', auth()->user()->id)
            ->get();

        return view('pages.notification', compact('notifications'));
    }
}
