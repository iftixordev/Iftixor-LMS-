<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PhoneVerification extends Model
{
    protected $fillable = [
        'phone',
        'request_id',
        'code',
        'is_verified',
        'expires_at'
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'expires_at' => 'datetime'
    ];

    public function isExpired()
    {
        return $this->expires_at->isPast();
    }

    public function isValid()
    {
        return !$this->is_verified && !$this->isExpired();
    }
}