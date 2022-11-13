<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{

    public function ownerNotifications()
    {
        $notification = [
            'notifications' => auth()->user()->notifications,
            'unread' => auth()->user()->unreadNotifications,
            'read' => auth()->user()->readNotifications
        ];

        return response()->json([
            'data' => $notification
        ]);
    }

    public function ownerNotificationsDetails(Request $request)
    {
        $notification = DB::table('notifications')
                        ->where('id', $request->route('notification'))
                        ->first();

        auth()->user()->unreadNotifications->where('id', $notification->id)->markAsRead();

        return response()->json([
            'data' => $notification
        ]);
    }

    public function customerNotifications()
    {

        $notification = [
            'notifications' => auth()->user()->notifications,
            'unread' => auth()->user()->unreadNotifications,
            'read' => auth()->user()->readNotifications
        ];

        return response()->json([
            'data' => $notification
        ]);
    }

    public function customerNotificationsDetails(Request $request)
    {
        $notification = DB::table('notifications')
        ->where('id', $request->route('notification'))
        ->first();

        auth()->user()->unreadNotifications->where('id', $notification->id)->markAsRead();

        $queue = Queue::with('customer','service', 'service.shop.application')
            ->where('id', json_decode($notification->data)->queue_id)->first();

        return response()->json([
            'data' => $queue
        ]);
    }
}
