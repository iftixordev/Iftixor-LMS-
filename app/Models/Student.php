<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'first_name', 'last_name', 'birth_date', 'gender',
        'phone', 'email', 'address', 'parent_name', 'parent_phone',
        'parent_email', 'photo', 'status', 'enrollment_date', 'notes', 'branch_id'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'enrollment_date' => 'date',
    ];

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class)->withPivot('enrolled_date', 'status')->withTimestamps();
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function coins(): HasMany
    {
        return $this->hasMany(Coin::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    public function courseApplications(): HasMany
    {
        return $this->hasMany(CourseApplication::class);
    }

    public function getCoinBalanceAttribute(): int
    {
        try {
            if (!$this->exists || !$this->id) {
                return 0;
            }
            
            $earned = $this->coins()->where('type', 'earned')->sum('amount');
            $spent = $this->coins()->where('type', 'spent')->sum('amount');
            
            $earned = is_numeric($earned) ? (int)$earned : 0;
            $spent = is_numeric($spent) ? (int)$spent : 0;
            
            return $earned - $spent;
        } catch (\Exception $e) {
            \Log::error('Coin balance calculation error: ' . $e->getMessage());
            return 0;
        }
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
        
        // Default avatar yaratish
        $initials = strtoupper(substr($this->first_name ?? 'U', 0, 1) . substr($this->last_name ?? 'N', 0, 1));
        $colors = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7', '#DDA0DD', '#98D8C8'];
        $color = $colors[ord($initials[0] ?? 'A') % count($colors)];
        
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
