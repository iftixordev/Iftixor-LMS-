<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id', 'type', 'subject', 'description', 'scheduled_at', 'completed'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'completed' => 'boolean',
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function getTypeBadgeAttribute(): string
    {
        return match($this->type) {
            'call' => 'bg-primary',
            'email' => 'bg-info',
            'sms' => 'bg-success',
            'meeting' => 'bg-warning',
            'note' => 'bg-secondary',
            default => 'bg-secondary'
        };
        return $badges[$this->type] ?? 'bg-secondary';
    }
}
