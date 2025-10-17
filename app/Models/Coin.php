<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Coin extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'amount', 'type', 'reason', 'description', 'admin_id'
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public static function addCoins(int $studentId, int $amount, string $reason, string $description = null)
    {
        return self::create([
            'student_id' => $studentId,
            'amount' => $amount,
            'type' => 'earned',
            'reason' => $reason,
            'description' => $description,
            'admin_id' => auth()->id(),
        ]);
    }

    public static function spendCoins(int $studentId, int $amount, string $reason, string $description = null)
    {
        return self::create([
            'student_id' => $studentId,
            'amount' => $amount,
            'type' => 'spent',
            'reason' => $reason,
            'description' => $description,
            'admin_id' => auth()->id(),
        ]);
    }
}
