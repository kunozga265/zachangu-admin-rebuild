<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications=Notification::latest()->get();

        foreach ($notifications as $notification){
            if($notification->read==0){
                $notification->update([
                    'read'  =>  1
                ]);
            }
        }

        return Inertia::render('Notifications',[
            'notifications'=>NotificationResource::collection($notifications)
        ]);
    }
}
