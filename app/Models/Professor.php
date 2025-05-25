<?php

namespace App\Models;

use App\Http\Controllers\CourseController; // Note: Cela devrait être un modèle, pas un contrôleur
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;

    /**
     * Définit les champs qui peuvent être remplis en masse.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'comments',
        'photo',
        'gender',
        'last_name',
        'first_name',
        'phone',
        'email',
        'role',
        'birth_date',
        'birth_place',
        'nationality',
        'address',
        'city',
        'zip_code',
        'country',
    ];

    /**
     * Définit la relation avec le modèle User (un professeur appartient à un utilisateur).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Génère l'URL de la photo du professeur (retourne une image par défaut si aucune photo).
     *
     * @return string
     */
    public function getPhotoUrlAttribute()
    {
        return $this->photo ? asset('storage/' . $this->photo) : asset('images/default-avatar.png');
    }

    /**
     * Définit la relation avec les cours (un professeur peut avoir plusieurs cours).
     * Note : CourseController devrait être remplacé par Course (modèle).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courses()
    {
        return $this->hasMany(CourseController::class); // À corriger en Course::class
    }
}
