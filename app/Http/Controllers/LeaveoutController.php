<?php

namespace App\Http\Controllers;

use App\Models\Leaveout;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LeaveoutController extends Controller
{
    public function index()
    {
        $leaveouts = Leaveout::latest()->with('student', 'createdBy')->get();
        $count_leaveouts = count($leaveouts);

        return view('admin.leaveouts.index', compact('leaveouts', 'count_leaveouts'));
    }

    public function create()
    {
        $students = Student::orderBy('first_name')->get();

        return view('admin.leaveouts.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'category' => ['required', Rule::in(Leaveout::CATEGORIES)],
            'comment' => 'required|string',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'student_id' => 'required|exists:students,id',
        ], [
            'student_id.required' => 'You have to select a student',
            'comment.required' => 'You must enter a comment.',
        ]);

        Leaveout::create($validated_data);

        return redirect()->route('leaveouts.index')->with('success', 'Leaveout has been added.');
    }

    public function edit(Leaveout $leaveout)
    {
        $students = Student::orderBy('first_name')->get();

        return view('admin.leaveouts.edit', compact('students', 'leaveout'));
    }

    public function update(Request $request, Leaveout $leaveout)
    {
        $validated_data = $request->validate([
            'category' => ['required', Rule::in(Leaveout::CATEGORIES)],
            'comment' => 'required|string',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'student_id' => 'required|exists:students,id',
        ], [
            'student_id.required' => 'You have to select a student',
            'comment.required' => 'You must enter a comment.',
        ]);

        $leaveout->update($validated_data);

        return redirect()->route('leaveouts.index')->with('success', 'Leaveout has been updated.');
    }

    public function destroy(Leaveout $leaveout)
    {
        $leaveout->delete();

        return redirect()->route('leaveouts.index')->with('success', 'Leaveout has been deleted.');
    }
}
