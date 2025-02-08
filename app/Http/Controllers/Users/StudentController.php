<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Classrooms\Classroom;
use App\Models\Dorm;
use App\Models\Guardian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('dorm', 'classroom', 'guardians')->get();
        $count_students = count($students);

        return view("admin.users.students.index", compact("students", "count_students"));
    }

    public function create()
    {
        $classrooms = Classroom::orderBy('name')->get();
        $dorms = Dorm::orderBy('name')->get();
        $guardians = Guardian::orderBy('first_name')->get();

        return view('admin.users.students.create', compact('classrooms', 'dorms', 'guardians'));
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'adm_no' => 'nullable|unique:students|max:20',
            'first_name' => 'required|string|max:80',
            'last_name' => 'required|string|max:100',
            'dorm_room' => 'nullable|string|max:120',
            'year_admitted' => 'nullable|date',
            'graduation_status' => 'nullable|boolean',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => ['nullable', Password::defaults()],
            'classroom_id' => 'required|exists:classrooms,id',
            'dorm_id' => 'nullable|exists:dorms,id',
            'guardian_ids' => 'nullable|array',
            'guardian_ids.*' => 'exists:guardians,id',
        ], [
            'classroom_id.required' => 'A classroom has to be selected.'
        ]);

        DB::transaction(function () use ($request, $validated_data) {
            $image_path = null;
            if ($request->hasFile('image')) {
                $image_path = $request->file('image')->store('students', 'public');
            }

            $student = Student::create([
                'adm_no' => $validated_data['adm_no'],
                'first_name' => $validated_data['first_name'],
                'last_name' => $validated_data['last_name'],
                'dorm_room' => $validated_data['dorm_room'],
                'year_admitted' => $validated_data['year_admitted'],
                'graduation_status' => $validated_data['graduation_status'] ?? 0,
                'dob' => $validated_data['dob'],
                'gender' => $validated_data['gender'],
                'image' => $image_path,
                'password' => Hash::make($validated_data['password'] ?? 'st123456'),
                'classroom_id' => $validated_data['classroom_id'] ?? null,
                'dorm_id' => $validated_data['dorm_id'] ?? null,
            ]);

            if (isset($validated_data['guardian_ids'])) {
                $student->guardians()->attach($validated_data['guardian_ids']);
            }
        });

        return redirect()->route('students.index')->with('success', 'Student has been added.');
    }

    public function show(Student $student)
    {
        $student = $student->load('dorm', 'classroom', 'guardians');

        return view('admin.users.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $classrooms = Classroom::orderBy('name')->get();
        $dorms = Dorm::orderBy('name')->get();
        $guardians = Guardian::orderBy('first_name')->get();
        $student = $student->load('dorm', 'classroom', 'guardians');

        return view('admin.users.students.edit', compact('student', 'classrooms', 'dorms', 'guardians'));
    }

    public function update(Request $request, Student $student)
    {
        $validated_data = $request->validate([
            'adm_no' => 'nullable|unique:students,adm_no,' . $student->id . '|max:20',
            'first_name' => 'required|string|max:80',
            'last_name' => 'required|string|max:100',
            'dorm_room' => 'nullable|string|max:120',
            'year_admitted' => 'nullable|date',
            'graduation_status' => 'nullable|boolean',
            'graduation_date' => 'nullable|date',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => ['nullable', Password::defaults()],
            'classroom_id' => 'required|exists:classrooms,id',
            'dorm_id' => 'nullable|exists:dorms,id',
            'guardian_ids' => 'nullable|array',
            'guardian_ids.*' => 'exists:guardians,id',
        ], [
            'classroom_id.required' => 'A classroom has to be selected.'
        ]);

        DB::transaction(function () use ($request, $student, $validated_data) {
            if ($request->hasFile('image')) {
                if ($student->image && Storage::disk('public')->exists($student->image)) {
                    Storage::disk('public')->delete($student->image);
                }
                $image_path = $request->file('image')->store('students', 'public');
            } else {
                $image_path = $student->image;
            }

            $student->update([
                'adm_no' => $validated_data['adm_no'],
                'first_name' => $validated_data['first_name'],
                'last_name' => $validated_data['last_name'],
                'dorm_room' => $validated_data['dorm_room'],
                'year_admitted' => $validated_data['year_admitted'],
                'graduation_status' => $validated_data['graduation_status'] ?? 0,
                'graduation_date' => $validated_data['graduation_date'],
                'dob' => $validated_data['dob'],
                'gender' => $validated_data['gender'],
                'image' => $image_path,
                'password' => $validated_data['password'] ? Hash::make($validated_data['password']) : $student->password,
                'classroom_id' => $validated_data['classroom_id'] ?? null,
                'dorm_id' => $validated_data['dorm_id'] ?? null,
            ]);

            if (isset($validated_data['guardian_ids'])) {
                $student->guardians()->sync($validated_data['guardian_ids']);
            } else {
                $student->guardians()->detach();
            }
        });

        return redirect()->back()->with('success', 'Student has been updated.');
    }

    public function destroy(Student $student)
    {
        DB::transaction(function () use ($student) {
            if ($student->image && Storage::disk('public')->exists($student->image)) {
                Storage::disk('public')->delete($student->image);
            }

            $student->guardians()->detach();

            $student->delete();
        });

        return redirect()->route('students.index')->with('success', 'Student has been deleted.');
    }
}
