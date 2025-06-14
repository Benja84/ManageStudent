<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class CloseDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'type',
        'description',
        'imported',
    ];

    protected $casts = [
        'imported' => 'boolean'
    ];

    public function getDateFrenchFormatAttribute()
    {
        return Carbon::parse($this->date)->format('d/m/Y');
    }
}
