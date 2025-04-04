<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

     public function patient()
     {
        return $this->hasOne(Patient::class, 'userID', 'id');
     }

     public function doctor()
     {
         return $this->hasOne(Doctor::class, 'userID');
     }

     

    protected $fillable = [
        'name',
        'email',
        'role',
        'password',

        'address',
        'mobile',
        'zipCode',
        'joinDate',
        'dob',
        'gender',
        'refPlan',
        'wdays'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
