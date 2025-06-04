<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * Velden die ingevuld mogen worden.
     */
    protected $fillable = [
        'title',
        'description',
        'cover_image',
        'pdf_file',
    ];

    /**
     * Relatie: een boek heeft meerdere quizzen.
     */
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    /**
     * Optioneel: scope om met quiz-telling op te halen.
     */
    public function scopeWithQuizCount($query)
    {
        return $query->withCount('quizzes');
    }
}
