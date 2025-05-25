<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'photo',
        'gender',
        'last_name',
        'first_name',
        'email',
        'phone',
        'birth_date',
        'birth_place',
        'nationality',
        'address',
        'city',
        'zip_code',
        'country',
        'comments',
    ];
}
