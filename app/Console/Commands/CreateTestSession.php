<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserSession;
use App\Models\User;

class CreateTestSession extends Command
{
    protected $signature = 'session:test {user_id}';
    protected $description = 'Create test session for user';

    public function handle()
    {
        $userId = $this->argument('user_id');
        $user = User::find($userId);
        
        if (!$user) {
            $this->error('User not found');
            return;
        }

        UserSession::create([
            'user_id' => $userId,
            'session_id' => 'test_session_' . time(),
            'ip_address' => '192.168.1.100',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            'device_type' => 'desktop',
            'device_name' => 'Windows',
            'browser' => 'Chrome',
            'platform' => 'Windows',
            'location' => 'Test Location',
            'is_current' => false,
            'last_activity' => now()->subMinutes(30)
        ]);

        $this->info('Test session created for user: ' . $user->name);
    }
}
