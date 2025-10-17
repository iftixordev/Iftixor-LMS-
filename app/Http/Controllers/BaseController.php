<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    protected $currentBranch;
    
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->setCurrentBranch();
            return $next($request);
        });
    }
    
    protected function setCurrentBranch()
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return;
            }
            
            \DB::setDefaultConnection('sqlite');
            
            if (!$user->branch_id) {
                $branchId = session('current_branch_id');
                if ($branchId) {
                    $this->currentBranch = Branch::find($branchId);
                }
            } else {
                $this->currentBranch = Branch::find($user->branch_id);
                session(['current_branch_id' => $user->branch_id]);
            }
            
            view()->share('currentBranch', $this->currentBranch);
        } catch (\Exception $e) {
            // Xatolik bo'lsa, davom etamiz
        }
    }
    
    protected function switchToBranchDatabase($branch)
    {
        // Bu metod BranchMiddleware tomonidan bajariladi
    }
    
    protected function getCurrentBranch()
    {
        return $this->currentBranch;
    }
}