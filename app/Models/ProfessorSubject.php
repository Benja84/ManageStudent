<?php

namespace App\Models;

use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProfessorSubject extends Pivot
{
    use HasFactory,EloquentJoin;

    protected $fillable = ['professor_id', 'subject_id'];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The professor that belong to the subject.
     */
    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    /**
     * The subject that belong to the professor.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class)->withTrashed();
    }
}
