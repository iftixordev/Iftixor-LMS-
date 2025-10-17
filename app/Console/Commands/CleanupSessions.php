<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserSession;
use Illuminate\Support\Facades\DB;

class CleanupSessions extends Command
{
    protected $signature = 'sessions:cleanup';
    protected $description = 'Clean up orphaned user sessions';

    public function handle()
    {
        // Get all valid Laravel session IDs
        $validSessions = DB::connection('sqlite')->table('sessions')->pluck('id');
        
        // Delete user sessions that don't have corresponding Laravel sessions
        $deleted = UserSession::on('sqlite')
            ->whereNotIn('session_id', $validSessions)
            ->delete();
            
        $this->info("Cleaned up {$deleted} orphaned sessions");
        
        // Also clean up old sessions (older than 30 days)
        $oldDeleted = UserSession::on('sqlite')
            ->where('last_activity', '<', now()->subDays(30))
            ->delete();
            
        $this->info("Cleaned up {$oldDeleted} old sessions");
    }
}