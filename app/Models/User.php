<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    static $permissions = NULL;

    protected $cascadeDeletes = ['student', 'professor'];

    public const ADMIN = 'administrators';
    public const PROFESSOR = 'professors';
    public const TRAINEE = 'students';
    public const COORDINATOR = 'coordinators';
    public const ADVISOR = 'advisors';
    public const SECRETARY = 'secretaries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'gender',
        'firstname',
        'lastname',
        'email',
        'phone',
        'birthdate',
        'birthplace_postcode',
        'birthplace_city',
        'address_street',
        'address_postcode',
        'address_city',
        'password',
        'active',
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

    public function student(){
        return $this->hasOne(Student::class);
    }
}
