<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'abbreviation',
    ];

    /* RELATIONS */
    /**
     * The sections that belong to the subject.
     */
    public function sections()
    {
        return $this->belongsToMany(Section::class, 'section_subject')
                    ->using(SectionSubject::class)
                    ->withTimestamps();
    }

    /**
     * The groups that belong to the subject.
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_subject')
                    ->using(GroupSubject::class)
                    ->withTimestamps();
    }

    public function professors()
    {
        return $this->belongsToMany(Professor::class, 'professor_subject')
                    ->using(ProfessorSubject::class)
                    ->with('user');
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

}
