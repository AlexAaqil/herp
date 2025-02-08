<?php

namespace App\Http\Controllers;

use App\Models\TeacherSubjectClassroom;
use App\Models\Classrooms\Classroom;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherSubjectClassroomController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'classroom_id' => ['required', 'exists:classrooms,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'teacher_id' => ['required', 'exists:users,id'],
        ], [
            'classroom_id.required' => 'A classroom is required.',
            'subject_id.required' => 'A subject is required.',
        ]);

        if (TeacherSubjectClassroom::where($validated)->exists()) {
            return redirect()->back()->with('error', 'This teacher is already assigned to this subject and class.');
        }

        DB::transaction(function () use ($validated) {
            TeacherSubjectClassroom::create($validated);
        });

        return redirect()->back()->with('success', 'Class subject has been assigned.');
    }

    public function edit(TeacherSubjectClassroom $teacher_subject)
    {
        $classrooms = Classroom::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        $teacher_subject->load('classroom', 'subject', 'teacher');

        return view('admin.users.teachers.edit-teacher-subjects', compact('teacher_subject', 'classrooms', 'subjects'));
    }

    public function update(Request $request, TeacherSubjectClassroom $teacher_subject)
    {
        $validated = $request->validate([
            'classroom_id' => ['required', 'exists:classrooms,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
        ], [
            'classroom_id.required' => 'A classroom is required.',
            'subject_id.required' => 'A subject is required.',
        ]);

        $existing_assignment = TeacherSubjectClassroom::where('classroom_id', $validated['classroom_id'])
            ->where('subject_id', $validated['subject_id'])
            ->where('id', '!=', $teacher_subject->id)
            ->first();

        if ($existing_assignment) {
            return redirect()->back()->with('error', 'This teacher is already assigned to this subject and class.');
        }

        DB::transaction(function () use ($teacher_subject, $validated) {
            $teacher_subject->update($validated);
        });

        return redirect()->route('teachers.index')->with('success', 'Class subject has been update.');
    }

    public function destroy(TeacherSubjectClassroom $teacher_subject)
    {
        $teacher_subject->delete();

        return redirect()->route('teachers.index')->with('success', 'Teacher subject assignment has been deleted.');
    }
}
