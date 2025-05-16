<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentRelation extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'type',        // father ou mother
        'firstname',
        'lastname',
        'company',
        'contact',
        'message',
    ];

    /**
     * Relation inverse : chaque parent appartient à un étudiant.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
