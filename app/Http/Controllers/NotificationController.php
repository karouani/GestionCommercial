<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Notifications\RepliedToThread;


class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function MarkNotifRead(){
        foreach (Auth::user()->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
        
      
        $CountnotifNotRead = count(Auth::user()->unreadNotifications);
        return Response()->json(['CountnotifNotRead' => $CountnotifNotRead ]);
    }

    public function addNotification(Request $request){
        $user = Auth::user();
        \Notification::send($user, new RepliedToThread($request->reference_d));
        return Response()->json(['notif' => $request->reference_d ]);
    }

    public function getNotifications(){

        $notifications = Auth::user()->notifications;
        $CountnotifNotRead = count(Auth::user()->unreadNotifications);
        return Response()->json(['notifications' => $notifications ,'CountnotifNotRead' => $CountnotifNotRead ]);
     }

}
