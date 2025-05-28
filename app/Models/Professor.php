<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'section_id',
        // 'group_id',
        // 'phone',
        'comments',
        'documents',
    ];

    protected $with = ['user'];
}
