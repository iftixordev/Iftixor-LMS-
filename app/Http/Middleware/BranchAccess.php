<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchAccess
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $currentBranchId = session('current_branch_id');
        
        // Super admin (branch_id null) har qaysi filialga kirishi mumkin
        if (!$user->branch_id) {
            return $next($request);
        }
        
        // Oddiy foydalanuvchi faqat o'z filialiga kirishi mumkin
        if ($user->branch_id != $currentBranchId) {
            session(['current_branch_id' => $user->branch_id]);
        }
        
        return $next($request);
    }
}