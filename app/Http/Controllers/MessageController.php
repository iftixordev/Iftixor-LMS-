<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $conversations = Message::where('sender_id', Auth::id())
            ->orWhere('receiver_id', Auth::id())
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($message) {
                return $message->sender_id == Auth::id() 
                    ? $message->receiver_id 
                    : $message->sender_id;
            });

        $users = collect();
        $users = $users->merge(Student::select('id', 'full_name as name', 'phone')->get()->map(function ($student) {
            $student->type = 'student';
            return $student;
        }));
        $users = $users->merge(Teacher::select('id', 'full_name as name', 'phone')->get()->map(function ($teacher) {
            $teacher->type = 'teacher';
            return $teacher;
        }));

        return view('admin.messages.index', compact('conversations', 'users'));
    }

    public function show($userId)
    {
        $messages = Message::where(function ($query) use ($userId) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', Auth::id());
        })->with(['sender', 'receiver'])
        ->orderBy('created_at', 'asc')
        ->get();

        // Mark messages as read
        Message::where('sender_id', $userId)
            ->where('receiver_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $receiver = User::find($userId) ?? 
                   Student::find($userId) ?? 
                   Teacher::find($userId);

        return view('admin.messages.show', compact('messages', 'receiver'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|integer',
            'message' => 'required|string|max:1000',
            'type' => 'in:text,sms,email'
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'type' => $request->type ?? 'text'
        ]);

        if ($request->type === 'sms') {
            $this->sendSMS($request->receiver_id, $request->message);
        }

        return response()->json(['success' => true, 'message' => $message]);
    }

    private function sendSMS($receiverId, $message)
    {
        // SMS integration logic here
        // This would integrate with SMS providers like Eskiz.uz, Playmobile, etc.
    }

    public function markAsRead($messageId)
    {
        Message::where('id', $messageId)
            ->where('receiver_id', Auth::id())
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }
}