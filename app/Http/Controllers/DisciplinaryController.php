<?php

namespace App\Http\Controllers;

use App\Models\Disciplinary;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DisciplinaryController extends Controller
{
    public function index()
    {
        $disciplinaries = Disciplinary::latest()->get();
        $count_disciplinaries = count($disciplinaries);
        $count_major = $disciplinaries->where('category', 'major')->count();
        $count_minor = $disciplinaries->where('category', 'minor')->count();

        return view('admin.disciplinaries.index', compact('disciplinaries', 'count_disciplinaries', 'count_major', 'count_minor'));
    }

    public function create()
    {
        $students = Student::orderBy('first_name')->where('graduation_status', 0)->get();

        return view('admin.disciplinaries.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'category' => 'required|in:minor,major',
            'comment' => 'required|string',
            'student_id' => 'required|integer|exists:students,id',
        ]);

        DB::transaction(function() use ($validated_data) {
            Disciplinary::create($validated_data);
        });

        return redirect()->route('disciplinaries.index')->with('success', 'Disciplinary has been added.');
    }

    public function edit(Disciplinary $disciplinary)
    {
        $students = Student::orderBy('first_name')->where('graduation_status', 0)->get();
        $disciplinary = $disciplinary->load('student');

        return view('admin.disciplinaries.edit', compact('students', 'disciplinary'));
    }

    public function update(Request $request, Disciplinary $disciplinary)
    {
        $validated_data = $request->validate([
            'category' => 'required|in:minor,major',
            'comment' => 'required|string',
            'student_id' => 'required|integer|exists:students,id',
        ]);

        DB::transaction(function() use ($disciplinary, $validated_data) {
            $disciplinary->update($validated_data);
        });

        return redirect()->route('disciplinaries.index')->with('success', 'Disciplinary has been updated.');
    }

    public function destroy(Disciplinary $disciplinary)
    {
        $disciplinary->delete();

        return redirect()->route('disciplinaries.index')->with('success', 'Disciplinary has been deleted.');
    }
}
