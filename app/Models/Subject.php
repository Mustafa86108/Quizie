<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'teacher_id'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    // Relatie: Een onderwerp heeft veel vragen
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    // Relatie: Een onderwerp heeft veel quizzen
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}
