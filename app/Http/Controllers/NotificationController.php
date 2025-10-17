<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orWhereNull('user_id') // Global notifications
            ->latest()
            ->paginate(20);

        return view('admin.notifications.index', compact('notifications'));
    }

    public function create()
    {
        return view('admin.notifications.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,success,warning,error',
            'is_global' => 'boolean'
        ]);

        Notification::create([
            'title' => $request->title,
            'message' => $request->message,
            'type' => $request->type,
            'user_id' => $request->is_global ? null : Auth::id(),
            'is_read' => false
        ]);

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Bildirishnoma yuborildi');
    }

    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id === Auth::id() || $notification->user_id === null) {
            $notification->update(['is_read' => true]);
        }

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->orWhereNull('user_id')
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    public function getUnreadCount()
    {
        $count = Notification::where('user_id', Auth::id())
            ->orWhereNull('user_id')
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }
}