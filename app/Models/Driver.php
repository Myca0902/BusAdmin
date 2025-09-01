<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $table = 'drivers'; // Explicit table name (optional)

    protected $fillable = [
        'full_name',
        'address',
        'date_of_birth',
        'email',
        'phone_number',
        'driver_id',
        'password',
        'government_id',
        'gov_id_image',
        'license_front',
        'license_back',
        'status'
    ];

    protected $hidden = [
        'password',
    ];
}
