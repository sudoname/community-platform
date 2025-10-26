<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()
            ->notifications()
            ->paginate(20);

        $unreadCount = $request->user()->unreadNotifications->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    public function markAsRead(Request $request, $notificationId)
    {
        $notification = $request->user()
            ->notifications()
            ->findOrFail($notificationId);

        $notification->markAsRead();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Notification marked as read');
    }

    public function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'All notifications marked as read');
    }
}
