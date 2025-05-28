<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'abbreviation',
        'promotion',
        'pricing'
    ];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'section_subject')
                    ->using(SectionSubject::class)
                    ->withTimestamps()
                    ->withTrashed();
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }
}
