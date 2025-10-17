<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        // Always use main database for branch management
        \DB::setDefaultConnection('sqlite');
        $branches = Branch::with('manager')->paginate(10);
        return view('admin.branches.index', compact('branches'));
    }

    public function show(Branch $branch)
    {
        if (request()->expectsJson()) {
            return response()->json([
                'id' => $branch->id,
                'name' => $branch->name,
                'address' => $branch->address,
                'phone' => $branch->phone,
                'email' => $branch->email,
                'description' => $branch->description,
                'manager_id' => $branch->manager_id,
                'is_active' => $branch->is_active,
            ]);
        }
        
        // Switch to branch database to get stats
        $this->switchToBranchDatabase($branch);
        
        $stats = [
            'students_count' => \App\Models\Student::count(),
            'teachers_count' => \App\Models\Teacher::count(),
            'groups_count' => \App\Models\Group::count(),
            'courses_count' => \App\Models\Course::count(),
            'monthly_revenue' => \App\Models\Payment::whereRaw('strftime("%Y-%m", payment_date) = ?', [now()->format('Y-m')])->sum('amount')
        ];
        
        $recent_students = \App\Models\Student::latest()->take(5)->get();
        
        // Switch back to main database
        \DB::setDefaultConnection('sqlite');
        $branch->load('manager');
        
        return view('admin.branches.show', compact('branch', 'stats', 'recent_students'));
    }

    public function create()
    {
        return view('admin.branches.create');
    }

    public function store(Request $request)
    {
        try {
            \DB::setDefaultConnection('sqlite');
            
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'address' => 'required|string',
                'phone' => 'required|string|max:20',
                'email' => 'nullable|email|max:255',
                'description' => 'nullable|string',
            ]);

            $validated['is_active'] = $request->has('is_active') ? (bool)$request->is_active : true;
            
            $branch = Branch::create($validated);
            
            // Create branch database
            $this->createBranchDatabase($branch);
            
            return redirect()->route('admin.branches.index')->with('success', 'Filial muvaffaqiyatli yaratildi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xatolik: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Branch $branch)
    {
        // Always use main database for user management
        \DB::setDefaultConnection('sqlite');
        $managers = User::where('role', 'admin')->get();
        return view('admin.branches.edit', compact('branch', 'managers'));
    }

    public function update(Request $request, Branch $branch)
    {
        // Always use main database for branch operations
        \DB::setDefaultConnection('sqlite');
        
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'manager_id' => 'nullable|exists:users,id',
        ]);

        $oldName = $branch->name;
        $newName = $request->name;
        
        // Agar nom o'zgargan bo'lsa, yangi SQLite fayl yaratish
        if ($oldName !== $newName) {
            $this->renameBranchDatabase($oldName, $newName);
        }
        
        $branch->update($request->all());
        return redirect()->route('admin.branches.index')->with('success', 'Filial muvaffaqiyatli yangilandi');
    }

    public function destroy(Branch $branch)
    {
        // Always use main database for branch operations
        \DB::setDefaultConnection('sqlite');
        
        if ($branch->is_main) {
            return redirect()->route('admin.branches.index')->with('error', 'Asosiy filialni o\'chirib bo\'lmaydi!');
        }
        
        // SQLite fayl saqlanib turadi, faqat branch record o'chiriladi
        $branch->delete();
        return redirect()->route('admin.branches.index')->with('success', 'Filial o\'chirildi (Ma\'lumotlar saqlanib qoldi)');
    }

    public function switchBranch(Request $request)
    {
        // Use main database to find branch
        \DB::setDefaultConnection('sqlite');
        
        $branchId = $request->input('branch_id');
        $branch = Branch::find($branchId);
        
        if ($branch && $branch->is_active) {
            // Clear current session
            session()->forget('current_branch_id');
            session(['current_branch_id' => $branchId]);
            session()->save();
            
            // Force create branch database
            $this->createBranchDatabase($branch);
            
            return response()->json(['success' => true, 'message' => 'Filial almashtirildi']);
        }
        
        return response()->json(['success' => false, 'message' => 'Filial topilmadi']);
    }
    
    private function createBranchDatabase($branch)
    {
        try {
            $branchName = str_replace([' ', '-', "'", '"'], '_', strtolower($branch->name));
            $dbPath = database_path("branch_{$branchName}.sqlite");
            
            if (!file_exists($dbPath)) {
                $mainDbPath = database_path('database.sqlite');
                if (file_exists($mainDbPath)) {
                    copy($mainDbPath, $dbPath);
                    
                    $pdo = new \PDO("sqlite:{$dbPath}");
                    $tables = ['students', 'teachers', 'courses', 'groups', 'payments', 'leads', 'schedules', 'attendances'];
                    foreach ($tables as $table) {
                        $pdo->exec("DELETE FROM {$table}");
                    }
                } else {
                    touch($dbPath);
                }
            }
        } catch (\Exception $e) {
            // Log error but don't fail
        }
    }
    
    private function switchToBranchDatabase($branch)
    {
        try {
            $branchName = str_replace([' ', '-', "'", '"'], '_', strtolower($branch->name));
            $dbPath = database_path("branch_{$branchName}.sqlite");
            
            if (!file_exists($dbPath)) {
                $this->createBranchDatabase($branch);
            }
            
            config([
                'database.connections.branch_view' => [
                    'driver' => 'sqlite',
                    'database' => $dbPath,
                    'prefix' => '',
                    'foreign_key_constraints' => true,
                ]
            ]);
            
            \DB::setDefaultConnection('branch_view');
        } catch (\Exception $e) {
            \DB::setDefaultConnection('sqlite');
        }
    }
    
    private function renameBranchDatabase($oldName, $newName)
    {
        $oldBranchName = str_replace([' ', '-'], '_', strtolower($oldName));
        $newBranchName = str_replace([' ', '-'], '_', strtolower($newName));
        
        $oldDbPath = database_path("branch_{$oldBranchName}.sqlite");
        $newDbPath = database_path("branch_{$newBranchName}.sqlite");
        
        // Agar eski fayl mavjud bo'lsa, nusxalash
        if (file_exists($oldDbPath)) {
            copy($oldDbPath, $newDbPath);
        }
    }
}