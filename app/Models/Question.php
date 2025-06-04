<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    // public function subject() {
    //     return $this->belongsTo(Subject::class);
    // }
    public function quiz()
{
    return $this->belongsTo(Quiz::class);
}
    protected $fillable = [
        'quiz_id',
        'question_text',
        'image',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_option',
        'chapter'
    ];
}
