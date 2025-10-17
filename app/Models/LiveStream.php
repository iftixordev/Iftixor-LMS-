<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveStream extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'teacher_id',
        'course_id',
        'stream_key',
        'stream_url',
        'scheduled_at',
        'started_at',
        'ended_at',
        'status',
        'viewers_count',
        'max_viewers'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'started_at' => 'datetime',
        'ended_at' => 'datetime'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function scopeLive($query)
    {
        return $query->where('status', 'live');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function getStatusBadgeAttribute()
    {
        $colors = [
            'scheduled' => '#ff9800',
            'live' => '#4caf50',
            'ended' => '#6c757d'
        ];
        
        return [
            'color' => $colors[$this->status] ?? '#6c757d',
            'text' => ucfirst($this->status)
        ];
    }
}