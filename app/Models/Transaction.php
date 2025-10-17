<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'category', 'amount', 'description', 'transaction_date',
        'student_id', 'teacher_id', 'reference_number'
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'student_payment' => 'O\'quvchi to\'lovi',
            'teacher_salary' => 'O\'qituvchi maoshi',
            'rent' => 'Ijara haqi',
            'utilities' => 'Kommunal to\'lovlar',
            'marketing' => 'Marketing',
            'supplies' => 'Jihozlar',
            'other' => 'Boshqa',
            default => $this->category
        };
        return $labels[$this->category] ?? $this->category;
    }
}
