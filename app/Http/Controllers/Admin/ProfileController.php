<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\UserSession;

class ProfileController extends Controller
{
    public function show()
    {
        try {
            $user = Auth::user();
            
            // Load user sessions safely
            try {
                $user->load(['sessions' => function($query) {
                    $query->orderBy('last_activity', 'desc');
                }]);
            } catch (\Exception $e) {
                // If sessions can't be loaded, continue without them
            }
            
            return view('admin.profile.show', compact('user'));
        } catch (\Exception $e) {
            return view('admin.profile.show', ['user' => Auth::user()]);
        }
    }

    public function edit()
    {
        try {
            // Get current user - always use authenticated user for profile
            $user = Auth::user();
            
            return view('admin.profile.edit', compact('user'));
        } catch (\Exception $e) {
            return view('admin.profile.edit', ['user' => Auth::user()]);
        }
    }

    public function update(Request $request)
    {
        try {
            // Update current user - always use authenticated user for profile
            $user = Auth::user();
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|unique:users,phone,' . $user->id . ',id',
            'birth_date' => 'required|date|before:today',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Check current password if new password is provided
        if ($request->filled('password')) {
            if (!$request->filled('current_password') || !Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Joriy parol noto\'g\'ri.']);
            }
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $validated['photo'] = $request->file('photo')->store('users', 'public');
        }

        unset($validated['current_password'], $validated['password_confirmation']);
        $user->update($validated);

        return redirect()->route('admin.profile')->with('success', 'Profil muvaffaqiyatli yangilandi.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Profil yangilanishida xatolik: ' . $e->getMessage()]);
        }
    }

    public function terminateSession(Request $request)
    {
        try {
            $sessionId = $request->session_id;
            
            if (!$sessionId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session ID topilmadi'
                ]);
            }
            
            // Check if current session can terminate others
            $currentSession = UserSession::on('sqlite')->where('session_id', session()->getId())
                ->where('user_id', auth()->id())
                ->first();
                
            if (!$currentSession || !$currentSession->canTerminateOthers()) {
                return response()->json([
                    'success' => false,
                    'message' => "Faqat eng eski seans boshqalarini tugatishi mumkin"
                ]);
            }
            
            // Get session before deleting
            $sessionToDelete = UserSession::on('sqlite')->where('id', $sessionId)
                ->where('user_id', auth()->id())
                ->first();
                
            if (!$sessionToDelete) {
                return response()->json([
                    'success' => false,
                    'message' => 'Seans topilmadi'
                ]);
            }
            
            // Delete from Laravel sessions table
            \DB::connection('sqlite')->table('sessions')
                ->where('id', $sessionToDelete->session_id)
                ->delete();
            
            // Delete from user_sessions
            $deleted = $sessionToDelete->delete();

            return response()->json([
                'success' => $deleted,
                'message' => 'Seans tugatildi'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Xatolik: ' . $e->getMessage()
            ]);
        }
    }

    public function terminateAllSessions(Request $request)
    {
        try {
            // Check if current session can terminate others
            $currentSession = UserSession::on('sqlite')->where('session_id', session()->getId())
                ->where('user_id', auth()->id())
                ->first();
                
            if (!$currentSession || !$currentSession->canTerminateOthers()) {
                return response()->json([
                    'success' => false,
                    'message' => "Faqat eng eski seans boshqalarini tugatishi mumkin"
                ]);
            }
            
            // Get sessions to delete
            $sessionsToDelete = UserSession::on('sqlite')->where('user_id', auth()->id())
                ->where('session_id', '!=', session()->getId())
                ->get();
            
            // Delete from Laravel sessions table
            foreach ($sessionsToDelete as $session) {
                \DB::connection('sqlite')->table('sessions')
                    ->where('id', $session->session_id)
                    ->delete();
            }
            
            // Delete from user_sessions
            $deleted = UserSession::on('sqlite')->where('user_id', auth()->id())
                ->where('session_id', '!=', session()->getId())
                ->delete();

            return response()->json([
                'success' => true,
                'message' => "$deleted ta seans tugatildi"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Xatolik: ' . $e->getMessage()
            ]);
        }
    }
}
