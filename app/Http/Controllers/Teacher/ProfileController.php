<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $teacher = $user->teacher;
        return view('teacher.profile.show', compact('user', 'teacher'));
    }

    public function edit()
    {
        $user = Auth::user();
        $teacher = $user->teacher;
        return view('teacher.profile.edit', compact('user', 'teacher'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|unique:users,phone,' . $user->id,
            'birth_date' => 'required|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'specialization' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($request->filled('password')) {
            if (!$request->filled('current_password') || !Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Joriy parol noto\'g\'ri.']);
            }
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                \Storage::disk('public')->delete($user->photo);
            }
            $validated['photo'] = $request->file('photo')->store('users', 'public');
        }

        // Update teacher specific fields
        if ($user->teacher) {
            $user->teacher->update([
                'specialization' => $validated['specialization'] ?? null,
                'experience' => $validated['experience'] ?? null,
            ]);
        }

        unset($validated['current_password'], $validated['password_confirmation'], $validated['specialization'], $validated['experience']);
        $user->update($validated);

        return redirect()->route('teacher.profile')->with('success', 'Profil muvaffaqiyatli yangilandi.');
    }
}
