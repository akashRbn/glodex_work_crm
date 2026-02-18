<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Admin\Applicant;
use App\Models\Admin\Company;
use App\Models\Admin\StudentInfo;
use App\Models\Admin\UserInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'user_type',
        'organization_name',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Function to get the user who created this user
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function userInfo()
    {
        return $this->hasOne(UserInfo::class);
    }

    // App\Models\User.php
    public function companies()
    {
        return $this->hasMany(Company::class, 'lawyer_id', 'id');
    }


    public function applicantInfo()
    {
        return $this->hasOne(Applicant::class, 'user_id');
    }
}
