<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher; // Missing import for Teacher model
use App\Models\Subject; // Missing import for Subject model
use App\Models\Score;   // Missing import for Score model
use App\Models\Quiz;    // Missing import for Quiz model

class ScoreController extends Controller
{
    public function index()
{
    $scores = Score::with(['user', 'quiz'])->get();
    return view('scores.index', compact('scores'));
}
}
