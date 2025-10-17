<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'type',
        'target',
        'is_read',
        'sent_at'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'sent_at' => 'datetime'
    ];

    public static function createNotification($title, $message, $type = 'info', $target = 'admins')
    {
        return self::create([
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'target' => $target,
            'is_read' => false,
            'sent_at' => now()
        ]);
    }
}