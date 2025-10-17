<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\UserSession;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'first_name',
        'last_name', 
        'phone',
        'password',
        'birth_date',
        'photo',
        'role',
        'student_id',
        'teacher_id',
        'is_active',
        'passport_series',
        'passport_number',
        'address',
        'branch_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
        'birth_date' => 'date',
        'is_active' => 'boolean',
    ];
    
    public function getNameAttribute()
    {
        return $this->attributes['name'] ?? ($this->first_name . ' ' . $this->last_name);
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getPhotoUrlAttribute(): string
    {
        try {
            if ($this->photo && file_exists(storage_path('app/public/' . $this->photo))) {
                return asset('storage/' . $this->photo);
            }
        } catch (\Exception $e) {
            // Ignore file check errors
        }
        return asset('images/default-user.svg');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isTeacher()
    {
        return $this->role === 'teacher';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function isStaff()
    {
        return in_array($this->role, ['cashier', 'receptionist']);
    }

    public function sessions()
    {
        return $this->hasMany(UserSession::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function canAccessBranch($branchId)
    {
        if ($this->isAdmin() && !$this->branch_id) {
            return true; // Super admin
        }
        return $this->branch_id == $branchId;
    }
}
