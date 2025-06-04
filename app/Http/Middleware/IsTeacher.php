<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsTeacher
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()?->role !== 'teacher') {
            abort(403, 'Alleen docenten kunnen deze actie uitvoeren.');
        }

        return $next($request);
    }
}