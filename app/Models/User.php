<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use  HasFactory, Notifiable;

    /**
     * The table associated with the model.
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'fname', 'lname', 'middle_name', 'date_of_birth', 'gender', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Relationship: One User has one UserContact
     */
    public function contact()
    {
        return $this->hasOne(UserContact::class);
    }

    /**
     * Accessor for full name.
     */
    public function getFullNameAttribute()
    {
        return trim($this->Fname . ' ' . ($this->MiddleName ? $this->MiddleName . ' ' : '') . $this->Lname);
    }
}
