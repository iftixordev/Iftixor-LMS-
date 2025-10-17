<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'salary_month',
        'base_salary',
        'hourly_rate',
        'total_hours',
        'bonus',
        'deduction',
        'final_amount',
        'notes'
    ];

    protected $casts = [
        'salary_month' => 'date',
        'base_salary' => 'decimal:2',
        'hourly_rate' => 'decimal:2',
        'bonus' => 'decimal:2',
        'deduction' => 'decimal:2',
        'final_amount' => 'decimal:2',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }
}
