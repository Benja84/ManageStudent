<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'group_id',
        'subject_id',
        'room_id',
        'professor_id',
        'weekday',
        'start_time',
        'end_time',
        'duration',
        'date',
        'absences_checked',
        'checked_by_prof'
    ];
}
