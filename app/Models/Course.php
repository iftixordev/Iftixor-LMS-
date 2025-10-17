<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'duration_months', 'price',
        'min_students', 'max_students', 'status', 'curriculum', 'photo', 'branch_id',
        'course_type', 'meeting_link', 'requirements', 'certificate_template', 'lessons_count'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(CourseApplication::class);
    }

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo && \Storage::disk('public')->exists($this->photo)) {
            return asset('storage/' . $this->photo);
        }
        
        // Default course image
        return "data:image/svg+xml;base64," . base64_encode(
            '<svg width="200" height="120" xmlns="http://www.w3.org/2000/svg">' .
            '<rect width="200" height="120" fill="#f0f0f0"/>' .
            '<rect x="20" y="20" width="160" height="80" fill="#e0e0e0" rx="8"/>' .
            '<circle cx="60" cy="50" r="15" fill="#2196F3"/>' .
            '<rect x="85" y="40" width="70" height="8" fill="#2196F3" rx="4"/>' .
            '<rect x="85" y="55" width="50" height="6" fill="#ccc" rx="3"/>' .
            '</svg>'
        );
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function isOnline(): bool
    {
        return $this->course_type === 'online';
    }

    public function isOffline(): bool
    {
        return $this->course_type === 'offline';
    }

    public function getTypeDisplayAttribute(): string
    {
        return $this->course_type === 'online' ? 'Onlayn' : 'Oflayn';
    }
}
