<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_picture',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }

    // 🔁 Bestaat al: score-geschiedenis via scores tabel
    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class, 'scores')->withPivot('score', 'time_taken');
    }

    // 🔥 Nieuw: Beoordelingen via quiz_user pivot
    public function ratedQuizzes()
    {
        return $this->belongsToMany(Quiz::class)
                    ->withPivot('rating', 'feedback')
                    ->withTimestamps();
    }

    public function getProfilePictureUrlAttribute()
    {
        return $this->profile_picture 
            ? asset('storage/' . $this->profile_picture) 
            : asset('images/default-avatar.png');
    }
}
