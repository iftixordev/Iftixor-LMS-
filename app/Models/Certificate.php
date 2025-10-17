<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'certificate_number', 'student_id', 'course_id', 'template_id',
        'grade', 'completion_date', 'issued_date', 'additional_info', 'notes',
        'pdf_path', 'is_sent', 'sent_at'
    ];

    protected $casts = [
        'completion_date' => 'date',
        'issued_date' => 'date',
        'sent_at' => 'datetime',
        'is_sent' => 'boolean',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(CertificateTemplate::class);
    }

    public static function generateCertificateNumber()
    {
        return 'CERT-' . date('Y') . '-' . str_pad(self::count() + 1, 4, '0', STR_PAD_LEFT);
    }
}
