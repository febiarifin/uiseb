<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const TYPE_ADMIN = 1;
    public const TYPE_EDITOR = 2;
    public const TYPE_REVIEWER = 3;
    public const TYPE_PESERTA = 4;
    public const TYPE_COMMITTEE = 5;
    public const TYPE_SUPER_ADMIN = 6;

    public const IS_EMAIL_VERIFIED = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
        'type',
        'is_email_verified',
        'phone_number',
        'institution',
        'position',
        'subject_background',
        'scopus',
        'research_interest',
        'degree',
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
        'email_verified_at' => 'datetime',
    ];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function abstraks()
    {
        return $this->belongsToMany(Abstrak::class, 'abstrak_users', 'user_id', 'abstrak_id')->withPivot(['id']);
    }

    public function papers()
    {
        return $this->belongsToMany(Paper::class, 'paper_users', 'user_id', 'paper_id')->withPivot(['id']);
    }
}
