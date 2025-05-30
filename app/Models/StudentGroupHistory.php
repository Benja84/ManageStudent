<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentGroupHistory extends Model
{
    use HasFactory;

    protected $fillable = [
		'student_id',
		'group_id',
		'status',
		'tags'
	];

	protected $dates = [
		'created_at',
		'updated_at',
	];

	public function student()
	{
		return $this->belongsTo(Student::class);
	}

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
