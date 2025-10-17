<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'group_id', 'teacher_id', 'day_of_week', 'start_time', 'end_time', 'room', 'is_active'
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'is_active' => 'boolean'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function getDayNameAttribute()
    {
        $days = [
            'monday' => 'Dushanba',
            'tuesday' => 'Seshanba', 
            'wednesday' => 'Chorshanba',
            'thursday' => 'Payshanba',
            'friday' => 'Juma',
            'saturday' => 'Shanba',
            'sunday' => 'Yakshanba'
        ];
        return $days[$this->day_of_week] ?? $this->day_of_week;
    }
}