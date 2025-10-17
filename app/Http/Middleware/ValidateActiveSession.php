<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserSession;
use Illuminate\Support\Facades\Auth;

class ValidateActiveSession
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $sessionId = session()->getId();
            $userId = Auth::id();
            
            // Check if current session exists in user_sessions table
            $activeSession = UserSession::on('sqlite')
                ->where('session_id', $sessionId)
                ->where('user_id', $userId)
                ->first();
            
            if (!$activeSession) {
                // Session was terminated, logout user
                Auth::logout();
                session()->invalidate();
                session()->regenerateToken();
                
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Sizning seansingiz tugatildi',
                        'redirect' => route('login')
                    ], 401);
                }
                
                return redirect()->route('login')
                    ->with('error', 'Sizning seansingiz tugatildi. Qayta kiring.');
            }
        }
        
        return $next($request);
    }
}