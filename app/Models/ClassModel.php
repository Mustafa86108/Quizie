<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    protected $table = 'classes';
    use HasFactory;
    public function quizzes() {
        return $this->hasMany(Quiz::class);
    }
}
