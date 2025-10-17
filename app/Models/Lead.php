<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'phone', 'email', 'address', 'course_id',
        'status', 'source', 'notes', 'follow_up_date', 'branch_id'
    ];

    protected $casts = [
        'follow_up_date' => 'date',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(LeadActivity::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'new' => 'bg-primary',
            'contacted' => 'bg-info', 
            'interested' => 'bg-warning',
            'enrolled' => 'bg-success',
            'rejected' => 'bg-danger'
        ];
        return $badges[$this->status] ?? 'bg-secondary';
    }
}
