<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::orderBy('grade')->get();
        $count_grades = count($grades);

        return view('admin.grades.index', compact('grades', 'count_grades'));
    }

    public function create()
    {
        return view('admin.grades.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'grade' => ['required', 'string', 'max:2', 'unique:grades,grade'],
            'min_marks' => ['required', 'integer', 'min:0', 'max:100'],
            'max_marks' => ['required', 'integer', 'min:0', 'max:100', 'gte:min_marks'],
        ]);

        Grade::create($validated);

        return redirect(route('grades.index'))->with('success', 'Grade has been added');
    }

    public function edit(Grade $grade)
    {
        return view('admin.grades.edit', compact('grade'));
    }

    public function update(Request $request, Grade $grade)
    {
        $validated = $request->validate([
            'grade' => ['required', 'string', 'max:2', 'unique:grades,grade,'.$grade->id],
            'min_marks' => ['required', 'integer', 'min:0', 'max:100'],
            'max_marks' => ['required', 'integer', 'min:0', 'max:100', 'gte:min_marks'],
        ]);

        $grade->update($validated);

        return redirect(route('grades.index'))->with('success', 'Grade has been updated');
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();

        return redirect(route('grades.index'))->with('success', 'Grade has been deleted');
    }
}
