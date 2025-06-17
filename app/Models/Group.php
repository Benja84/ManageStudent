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

    public function students()
    {
        return $this
            ->morphedByMany(Student::class, 'groupable')
            ->withPivot('status')
            ->with('user')
            ->join('users', 'users.id', '=', 'user_id')
            ->orderBy('users.lastname')
            ->select('students.*');
    }

    public function professors()
    {
        return $this->morphedByMany(Professor::class, 'groupable')
                    ->withPivot('status')
                    ->wherePivot('status', NULL)
                    ->with('user')
                    ->join('users', 'users.id', '=', 'user_id')
                    ->orderBy('users.lastname')
                    ->select('professors.*');
    }

    public function coordinators()
    {
        return $this->morphedByMany(Professor::class, 'groupable')
            ->withPivot('status')
            ->wherePivot('status', 'Coordinateur')
            ->with('user')
            ->join('users', 'users.id', '=', 'user_id')
            ->orderBy('users.lastname')
            ->select('professors.*');
    }

    public function getFullnameAttribute()
    {
        return "$this->abbreviation $this->school_year (Section {$this->section->abbreviation})";
    }
}
