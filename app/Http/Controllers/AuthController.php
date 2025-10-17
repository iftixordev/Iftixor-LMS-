<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'phone' => 'required|string',
            'password' => 'required',
        ]);

        // Try login in main database first (for admins)
        \DB::setDefaultConnection('sqlite');
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
        }
        
        // Try login in branch databases for students/teachers
        \DB::setDefaultConnection('sqlite');
        $branches = \App\Models\Branch::where('is_active', true)->get();
        
        foreach ($branches as $branch) {
            $this->switchToBranchDatabase($branch);
            
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                $user = Auth::user();
                session(['current_branch_id' => $branch->id]);
                
                if ($user->role === 'teacher') {
                    return redirect()->route('teacher.dashboard');
                } elseif ($user->role === 'student') {
                    return redirect()->route('student.dashboard');
                } elseif (in_array($user->role, ['cashier', 'receptionist'])) {
                    return redirect()->route('staff.dashboard');
                }
                
                break; // Stop searching after successful login
            }
        }

        return back()->withErrors([
            'phone' => 'Telefon raqam yoki parol noto\'g\'ri.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }

    public function showRegister()
    {
        // Always use main database for branches
        \DB::setDefaultConnection('sqlite');
        $branches = \App\Models\Branch::where('is_active', true)->get();
        return view('auth.register', compact('branches'));
    }

    public function register(Request $request)
    {
        // First validate basic fields
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string',
            'password' => 'required|string|min:6',
            'birth_date' => 'required|date',
            'branch_id' => 'required|exists:branches,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Switch to selected branch database
        \DB::setDefaultConnection('sqlite');
        $branch = \App\Models\Branch::find($request->branch_id);
        $this->switchToBranchDatabase($branch);
        
        // Check phone uniqueness in branch database
        if (User::where('phone', $request->phone)->exists()) {
            return back()->withErrors(['phone' => 'Bu telefon raqam allaqachon ro\'yxatdan o\'tgan.'])->withInput();
        }
        
        $validated = $request->all();

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('users', 'public');
        }

        // Create user in branch database
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name . ' ' . $request->last_name,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'birth_date' => $request->birth_date,
            'photo' => $photoPath,
            'role' => 'student',
            'is_active' => true,
        ]);
        
        // Create student record
        $studentId = 'STD' . str_pad(\App\Models\Student::count() + 1, 4, '0', STR_PAD_LEFT);
        \App\Models\Student::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'gender' => 'male', // Default qiymat
            'parent_name' => 'Kiritilmagan',
            'parent_phone' => 'Kiritilmagan',
            'student_id' => $studentId,
            'enrollment_date' => now(),
            'status' => 'active',
        ]);
        
        // Auto login after registration - stay on branch database
        Auth::login($user);
        session(['current_branch_id' => $request->branch_id]);
        
        return redirect()->route('student.dashboard')->with('success', 'Muvaffaqiyatli ro\'yxatdan o\'tdingiz!');
    }
    
    private function switchToBranchDatabase($branch)
    {
        $branchName = str_replace([' ', '-', "'", '"'], '_', strtolower($branch->name));
        $dbPath = database_path("branch_{$branchName}.sqlite");
        
        config([
            'database.connections.branch' => [
                'driver' => 'sqlite',
                'database' => $dbPath,
                'prefix' => '',
                'foreign_key_constraints' => true,
            ]
        ]);
        
        \DB::setDefaultConnection('branch');
    }
    
    public function checkPhone(Request $request)
    {
        $phone = $request->input('phone');
        $branchId = $request->input('branch_id');
        
        // Switch to selected branch database
        \DB::setDefaultConnection('sqlite');
        $branch = \App\Models\Branch::find($branchId);
        
        if ($branch) {
            $this->switchToBranchDatabase($branch);
            $exists = User::where('phone', $phone)->exists();
            return response()->json(['exists' => $exists]);
        }
        
        return response()->json(['exists' => false]);
    }
}
