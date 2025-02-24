<?php

namespace App\Http\Controllers;

use App\Models\ExamRecord;
use App\Models\Classrooms\Classroom;
use App\Models\Exam;
use App\Models\Subject;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamRecordController extends Controller
{
    public function index(Request $request)
    {
        $classrooms = Classroom::orderBy('name')->get();
        $exams = Exam::orderBy('term', 'desc')->orderBy('year', 'desc')->get();
        $subjects = Subject::orderBy('name')->get();

        $exam_id = $request->input('exam_id');
        $subject_id = $request->input('subject_id');
        $classroom_id = $request->input('classroom_id');

        $selected_exam = null;
        $selected_subject = null;
        $selected_classroom = null;
        $students_with_marks = collect();
        $students_without_marks = collect();
        $existing_records = collect();

        // Only fetch data if all required inputs are filled
        if ($request->filled(['exam_id', 'subject_id', 'classroom_id'])) {
            $request->validate([
                'exam_id' => 'exists:exams,id',
                'subject_id' => 'exists:subjects,id',
                'classroom_id' => 'exists:classrooms,id',
            ]);

            // Fetch the selected exam, subject, and classroom
            $selected_exam = Exam::find($exam_id);
            $selected_subject = Subject::find($subject_id);
            $selected_classroom = Classroom::find($classroom_id);

            // Fetch all students from the selected classroom
            $students = Student::where('classroom_id', $classroom_id)->get();

            // Fetch existing records for the selected exam and subject
            $existing_records = ExamRecord::where('exam_id', $exam_id)
                                         ->where('subject_id', $subject_id)
                                         ->get()
                                         ->keyBy('student_id');

            // Separate students with and without marks
            $students_with_marks = $students->filter(function ($student) use ($existing_records) {
                return $existing_records->has($student->id);
            });

            $students_without_marks = $students->diff($students_with_marks);
        }

        return view('admin.exams.exam-records.index', compact(
            'classrooms',
            'exams',
            'subjects',
            'exam_id',
            'subject_id',
            'classroom_id',
            'selected_exam',
            'selected_subject',
            'selected_classroom',
            'students_with_marks',
            'students_without_marks',
            'existing_records'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'subject_id' => 'required|exists:subjects,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'marks' => 'required|array',
            'marks.*' => 'nullable|integer|min:0|max:100',
            'exclude' => 'sometimes|array'
        ]);
    
        // Fetch the classroom name
        $classroom = Classroom::find($validated['classroom_id']);
        $classroom_name = $classroom ? $classroom->name : null;
    
        DB::transaction(function () use ($validated, $classroom_name) {
            foreach ($validated['marks'] as $student_id => $mark) {
                // Handle student exclusion
                if (isset($validated['exclude'][$student_id])) {
                    ExamRecord::where([
                        'student_id' => $student_id,
                        'exam_id' => $validated['exam_id'],
                        'subject_id' => $validated['subject_id']
                    ])->delete();
                    continue;
                }
    
                if (!is_null($mark)) {
                    ExamRecord::updateOrCreate(
                        [
                            'student_id' => $student_id,
                            'exam_id' => $validated['exam_id'],
                            'subject_id' => $validated['subject_id']
                        ],
                        [
                            'classroom' => $classroom_name,
                            'marks' => $mark,
                            'grade' => ExamRecord::determineGrade($mark)
                        ]
                    );
                }
            }
        });
    
        return redirect()->route('exam-records.index', [
            'exam_id' => $validated['exam_id'],
            'subject_id' => $validated['subject_id'],
            'classroom_id' => $validated['classroom_id']
        ])->with('success', 'Marks saved successfully!');
    }
}