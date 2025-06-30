<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    // Liste des champs autorisés à être remplis en masse
    protected $fillable = [
        'photo',
        'user_id',
        'advisor_id',
        'nationality',
        'parent1_gender',
        'parent1_firstname',
        'parent1_lastname',
        'parent1_relation',
        'parent1_phone',
        'parent1_profession',
        'parent2_gender',
        'parent2_firstname',
        'parent2_lastname',
        'parent2_relation',
        'parent2_phone',
        'parent2_profession',
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function advisor(){
        return $this->belongsTo(Advisor::class);
    }

    public function groups()
    {
        return $this->morphToMany(Group::class, 'groupable')->withPivot('status');
    }

    public function studentGroupHistories()
    {
        return $this->hasMany(StudentGroupHistory::class)->orderBy('created_at', 'desc');
    }
}
