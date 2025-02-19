<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Classrooms\Classroom;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AssignmentController extends Controller
{
    public function index()
    {
        $user_level = Auth::user()->user_level_label;

        if ($user_level != 'super admin' && $user_level != 'admin') {
            $assignments = Assignment::with('classroom', 'subject')->where('teacher_id', Auth::id())->latest()->get();
        } else {
            $assignments = Assignment::with('teacher', 'classroom', 'subject')->latest()->get();
        }

        $count_assignments = count($assignments);

        return view('admin.assignments.index', compact('assignments', 'count_assignments'));
    }

    public function create()
    {
        $classrooms = Classroom::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();

        return view('admin.assignments.create', compact('classrooms', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date_issued' => 'required|date',
            'deadline' => 'required|date|after_or_equal:date_issued',
            'description' => 'required|string|max:2000',
            'uploaded_file' => [
                'required',
                'file',
                'max:2048',
                'mimes:pdf,docx,jpg,jpeg,png',
                'mimetypes:application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,image/jpeg,image/png',
            ],
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        DB::beginTransaction();

        try {
            $classroom = Classroom::find($request->classroom_id);
            $subject = Subject::find($request->subject_id);

            if ($request->hasFile('uploaded_file')) {
                $file_extension = $request->file('uploaded_file')->getClientOriginalExtension();

                $file_name = sprintf(
                    '%s-%s-%s-%s-%s.%s',
                    $classroom->name,
                    $subject->name,
                    'Assignment',
                    Carbon::now()->format('Ymd'),
                    Str::random(4),
                    $file_extension,
                );

                $file_path = $request->file('uploaded_file')->storeAs('assignments', $file_name, 'public');
            }

            Assignment::create([
                'date_issued' => $request->date_issued,
                'deadline' => $request->deadline,
                'description' => $request->description,
                'uploaded_file' => $file_path,
                'teacher_id' => Auth::id(),
                'classroom_id' => $request->classroom_id,
                'subject_id' => $request->subject_id,
            ]);

            DB::commit();

            return redirect()->route('assignments.index')->with('success', 'Assignment created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while creating the assignment.');
        }
    }

    public function edit(Assignment $assignment)
    {
        $classrooms = Classroom::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();

        return view('admin.assignments.edit', compact('assignment', 'classrooms', 'subjects'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        $request->validate([
            'date_issued' => 'required|date',
            'deadline' => 'required|date|after_or_equal:date_issued',
            'description' => 'required|string|max:2000',
            'uploaded_file' => [
                'nullable',
                'file',
                'max:2048',
                'mimes:pdf,docx,jpg,jpeg,png',
                'mimetypes:application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf,image/jpeg,image/png',
            ],
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);
    
        DB::beginTransaction();
    
        try {
            $is_classroom_updated = $assignment->classroom_id != $request->classroom_id;
            $is_subject_updated = $assignment->subject_id != $request->subject_id;
    
            $file_path = $assignment->uploaded_file;
    
            if ($request->hasFile('uploaded_file')) {
                // Delete the old file only if a new file is uploaded
                if ($assignment->uploaded_file && Storage::disk('public')->exists($assignment->uploaded_file)) {
                    Storage::disk('public')->delete($assignment->uploaded_file);
                }
    
                $classroom = Classroom::find($request->classroom_id);
                $subject = Subject::find($request->subject_id);
                $file_extension = $request->file('uploaded_file')->getClientOriginalExtension();
    
                $file_name = sprintf(
                    '%s-%s-%s-%s-%s.%s',
                    $classroom->name,
                    $subject->name,
                    'Assignment',
                    Carbon::now()->format('Ymd'),
                    Str::random(4),
                    $file_extension
                );
    
                $file_path = $request->file('uploaded_file')->storeAs('assignments', $file_name, 'public');
            } elseif ($is_classroom_updated || $is_subject_updated) {
                // Rename the file if classroom or subject is changed
                if ($assignment->uploaded_file && Storage::disk('public')->exists($assignment->uploaded_file)) {
                    $classroom = Classroom::find($request->classroom_id);
                    $subject = Subject::find($request->subject_id);
                    $file_extension = pathinfo($assignment->uploaded_file, PATHINFO_EXTENSION);
    
                    $new_file_name = sprintf(
                        '%s-%s-%s-%s-%s.%s',
                        $classroom->name,
                        $subject->name,
                        'Assignment',
                        Carbon::now()->format('Ymd'),
                        Str::random(4),
                        $file_extension
                    );
    
                    $new_file_path = 'assignments/' . $new_file_name;
                    Storage::disk('public')->move($assignment->uploaded_file, $new_file_path);
                    $file_path = $new_file_path;
                }
            }
    
            $assignment->update([
                'date_issued' => $request->date_issued,
                'deadline' => $request->deadline,
                'description' => $request->description,
                'uploaded_file' => $file_path,
                'teacher_id' => Auth::id(),
                'classroom_id' => $request->classroom_id,
                'subject_id' => $request->subject_id,
            ]);
    
            DB::commit();
    
            return redirect()->route('assignments.index')->with('success', 'Assignment updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while updating the assignment.');
        }
    }
    

    public function destroy(Assignment $assignment)
    {
        DB::beginTransaction();

        try {
            Storage::disk('public')->delete($assignment->uploaded_file);

            $assignment->delete();

            DB::commit();

            return redirect()->route('assignments.index')->with('success', 'Assignment deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while deleting the assignment.');
        }
    }

    public function download(Assignment $assignment)
    {
        $file_path = $assignment->uploaded_file;

        if (!Storage::disk('public')->exists($file_path)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        return response()->download(storage_path('app/public/' . $file_path));
    }
}