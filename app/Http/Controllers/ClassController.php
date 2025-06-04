<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher; // Missing import for Teacher model
use App\Models\Subject; // Missing import for Subject model
use App\Models\Score;   // Missing import for Score model
use App\Models\Quiz;    // Missing import for Quiz model
use App\Models\ClassModel;    // Missing import for Quiz model

class ClassController extends Controller
{
    public function index()
{
    $classes = ClassModel::all();
    return view('classes.index', compact('classes'));
}

public function create()
{
    return view('classes.create');
}

public function store(Request $request)
{
    ClassModel::create($request->all());
    return redirect()->route('classes.index');
}

public function edit($id)
{
    $class = ClassModel::findOrFail($id);
    return view('classes.edit', compact('class'));
}

public function update(Request $request, $id)
{
    $class = ClassModel::findOrFail($id);
    $class->update($request->all());
    return redirect()->route('classes.index');
}

public function destroy($id)
{
    $class = ClassModel::findOrFail($id);
    $class->delete();
    return redirect()->route('classes.index');
}

}
