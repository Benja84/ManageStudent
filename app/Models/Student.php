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
        'advison_id',
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function advisor(){
        return $this->belongsTo(Advisor::class);
    }
}
