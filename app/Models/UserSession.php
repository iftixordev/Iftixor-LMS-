<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Agent\Agent;

class UserSession extends Model
{
    protected $connection = 'sqlite';
    
    protected $fillable = [
        'user_id', 'session_id', 'ip_address', 'user_agent',
        'device_type', 'device_name', 'browser', 'platform',
        'location', 'is_current', 'last_activity', 'can_terminate_others'
    ];

    protected $casts = [
        'last_activity' => 'datetime',
        'is_current' => 'boolean',
        'can_terminate_others' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createFromRequest($request, $userId, $sessionId)
    {
        $agent = new Agent();
        $agent->setUserAgent($request->userAgent());

        return [
            'user_id' => $userId,
            'session_id' => $sessionId,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'device_type' => self::getDeviceType($agent),
            'device_name' => self::getDeviceName($agent),
            'browser' => $agent->browser(),
            'platform' => $agent->platform(),
            'location' => self::getLocation($request->ip()),
            'is_current' => true,
            'last_activity' => now(),
            'can_terminate_others' => false
        ];
    }

    private static function getDeviceType($agent)
    {
        if ($agent->isMobile()) return 'mobile';
        if ($agent->isTablet()) return 'tablet';
        if ($agent->isDesktop()) return 'desktop';
        return 'unknown';
    }

    public function canTerminateOthers()
    {
        // Eng eski session boshqalarini o'chira oladi
        $oldestSession = UserSession::on('sqlite')->where('user_id', $this->user_id)
            ->orderBy('created_at', 'asc')
            ->first();
            
        return $oldestSession && $oldestSession->id === $this->id;
    }

    public function getSessionAgeAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    private static function getDeviceName($agent)
    {
        if ($agent->isAndroidOS()) return 'Android';
        if ($agent->isiOS()) return 'iPhone/iPad';
        if ($agent->isWindows()) return 'Windows';
        if ($agent->isLinux()) return 'Linux';
        if ($agent->isMacOS()) return 'macOS';
        return $agent->device() ?: 'Unknown';
    }

    private static function getLocation($ip)
    {
        if ($ip === '127.0.0.1' || $ip === '::1') return 'Local';
        return 'Unknown';
    }

    public function getDeviceIconAttribute()
    {
        return match($this->device_type) {
            'mobile' => 'fas fa-mobile-alt',
            'tablet' => 'fas fa-tablet-alt',
            'desktop' => 'fas fa-desktop',
            default => 'fas fa-question-circle'
        };
    }
}