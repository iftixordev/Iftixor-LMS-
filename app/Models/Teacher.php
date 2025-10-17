<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'address',
        'specializations', 'education', 'hourly_rate', 'hire_date',
        'status', 'photo', 'branch_id'
    ];

    protected $casts = [
        'hire_date' => 'date',
        'hourly_rate' => 'decimal:2',
    ];

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }

    public function schedules(): HasManyThrough
    {
        return $this->hasManyThrough(Schedule::class, Group::class);
    }

    public function workloads(): HasMany
    {
        return $this->hasMany(TeacherWorkload::class);
    }

    public function salaries(): HasMany
    {
        return $this->hasMany(Salary::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo && \Storage::disk('public')->exists($this->photo)) {
            return asset('storage/' . $this->photo);
        }
        
        // Default teacher avatar yaratish
        $initials = strtoupper(substr($this->first_name ?? 'T', 0, 1) . substr($this->last_name ?? 'E', 0, 1));
        $colors = ['#6366f1', '#8b5cf6', '#ec4899', '#ef4444', '#f59e0b', '#10b981', '#06b6d4'];
        $color = $colors[ord($initials[0] ?? 'T') % count($colors)];
        
        return "data:image/svg+xml;base64," . base64_encode(
            '<svg width="80" height="80" xmlns="http://www.w3.org/2000/svg">' .
            '<rect width="80" height="80" fill="' . $color . '"/>' .
            '<text x="40" y="50" font-family="Arial" font-size="24" fill="white" text-anchor="middle" dominant-baseline="middle">' . $initials . '</text>' .
            '</svg>'
        );
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
