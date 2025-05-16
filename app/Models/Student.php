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
        'gender',
        'firstname',
        'lastname',
        'email',
        'phone',
        'birth',
        'nationality',
        'address',
        'user_id',
    ];

    /**
     * Déclaration de la relation "hasMany" avec le modèle Parent.
     */
    public function parents()
    {
        // Le nom du modèle doit être correct
        return $this->hasMany(ParentRelation::class);
    }

    // Optionnel : accès direct père/mère
    public function father()
    {
        return $this->hasOne(ParentRelation::class)->where('type', 'father');
    }

    public function mother()
    {
        return $this->hasOne(ParentRelation::class)->where('type', 'mother');
    }

    /**
     * Cast automatique du champ birth en objet Date.
     */
    protected $casts = [
        'birth' => 'date',
    ];
}
