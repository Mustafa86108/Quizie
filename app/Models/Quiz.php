<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'class_id',
        'book_id',
        'cover_image',
    ];

    // Relatie: Quiz hoort bij een klas
    public function classModel()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    // Relatie: Quiz heeft meerdere vragen
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    // Relatie: Quiz hoort bij een boek
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Relatie: Quiz heeft meerdere scores
    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    // 🔥 Nieuw: Relatie met users via quiz_user (feedback + rating)
    public function users()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('rating', 'feedback')
                    ->withTimestamps();
    }
}
