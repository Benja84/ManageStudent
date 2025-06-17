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

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function groups()
    {
        return $this->morphToMany(Group::class, 'groupable')
                    ->withPivot('status')
                    ->wherePivot('status', NULL)
                    ->with('section');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'professor_subject','professor_id', 'subject_id')
                    ->using(ProfessorSubject::class)
                    ->withTimestamps()
                    ->withTrashed();
    }

    
}
