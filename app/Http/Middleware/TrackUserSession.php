<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserSession;

class TrackUserSession
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $sessionId = session()->getId();
            $userId = auth()->id();

            // Clean up orphaned sessions (sessions that don't exist in Laravel sessions table)
            try {
                $existingSessions = \DB::connection('sqlite')->table('sessions')->pluck('id');
                UserSession::on('sqlite')->where('user_id', $userId)
                    ->whereNotIn('session_id', $existingSessions)
                    ->delete();
            } catch (\Exception $e) {
                // Sessions table might not exist, skip cleanup
            }

            // Mark all other sessions as not current
            UserSession::on('sqlite')->where('user_id', $userId)->update(['is_current' => false]);

            // Create or update current session
                $sessionData = UserSession::createFromRequest($request, $userId, $sessionId);
            $sessionData['is_current'] = true;
            
            UserSession::on('sqlite')->updateOrCreate(
                ['session_id' => $sessionId],
                $sessionData
            );
        }

        return $next($request);
    }
}