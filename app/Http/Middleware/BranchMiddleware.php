<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class BranchMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            DB::setDefaultConnection('sqlite');
            
            if (!session()->has('current_branch_id')) {
                $mainBranch = Branch::where('is_main', true)->first();
                if ($mainBranch) {
                    session(['current_branch_id' => $mainBranch->id]);
                }
            }
            
            if (session('current_branch_id')) {
                $branch = Branch::find(session('current_branch_id'));
                if ($branch) {
                    $this->setBranchDatabase($branch);
                }
            }
        } catch (\Exception $e) {
            // Xatolik bo'lsa, asosiy ma'lumotlar bazasini ishlatamiz
            DB::setDefaultConnection('sqlite');
        }
        
        return $next($request);
    }
    
    private function setBranchDatabase($branch)
    {
        try {
            $branchName = str_replace([' ', '-', "'", '"'], '_', strtolower($branch->name));
            $dbPath = database_path("branch_{$branchName}.sqlite");
            
            if (!file_exists($dbPath)) {
                $mainDbPath = database_path('database.sqlite');
                if (file_exists($mainDbPath)) {
                    copy($mainDbPath, $dbPath);
                    $this->clearBranchData($dbPath);
                } else {
                    touch($dbPath);
                }
            }
            
            config([
                'database.connections.branch' => [
                    'driver' => 'sqlite',
                    'database' => $dbPath,
                    'prefix' => '',
                    'foreign_key_constraints' => true,
                ]
            ]);
            
            if (!$this->isBranchOperation()) {
                DB::setDefaultConnection('branch');
            }
        } catch (\Exception $e) {
            // Xatolik bo'lsa, asosiy ma'lumotlar bazasini ishlatamiz
        }
    }
    
    private function clearBranchData($dbPath)
    {
        try {
            $pdo = new \PDO("sqlite:{$dbPath}");
            $pdo->exec("DELETE FROM students");
            $pdo->exec("DELETE FROM teachers");
            $pdo->exec("DELETE FROM courses");
            $pdo->exec("DELETE FROM groups");
            $pdo->exec("DELETE FROM payments");
            $pdo->exec("DELETE FROM leads");
            $pdo->exec("DELETE FROM schedules");
            $pdo->exec("DELETE FROM attendances");
        } catch (\Exception $e) {
            // Ignore errors
        }
    }
    
    private function isBranchOperation()
    {
        $uri = request()->getRequestUri();
        return strpos($uri, '/admin/branches') !== false;
    }
    

}