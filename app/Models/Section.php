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
        'pricing',
        'niveau',
    ];

    // Ajoute un accessor pour obtenir la promotion en texte
    public function getPromotionTextAttribute()
    {
        return match ($this->promotion) {
            1 => '1ère année',
            2 => '2ème année',
            3 => '3ème année',
            4 => '4ème année',
            5 => '5ème année',
            default => $this->promotion . 'ème année',
        };
    }

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
