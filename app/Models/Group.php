<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'abbreviation',
        'section_id',
        'school_year',
        'period_type'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class)
                    ->using(GroupSubject::class)
                    ->withTimestamps()
                    ->withTrashed();
    }
}
