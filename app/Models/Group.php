<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'course_id', 'teacher_id', 'start_date',
        'end_date', 'max_students', 'status', 'photo', 'branch_id', 'description'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class)->withPivot('enrolled_date', 'status')->withTimestamps();
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function workloads(): HasMany
    {
        return $this->hasMany(TeacherWorkload::class);
    }

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo && \Storage::disk('public')->exists($this->photo)) {
            return asset('storage/' . $this->photo);
        }
        
        // Default group image
        return "data:image/svg+xml;base64," . base64_encode(
            '<svg width="80" height="80" xmlns="http://www.w3.org/2000/svg">' .
            '<rect width="80" height="80" fill="#4CAF50"/>' .
            '<circle cx="30" cy="35" r="8" fill="white"/>' .
            '<circle cx="50" cy="35" r="8" fill="white"/>' .
            '<circle cx="40" cy="55" r="8" fill="white"/>' .
            '</svg>'
        );
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
