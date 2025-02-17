<?php

namespace App\Http\Controllers;

use App\Models\Textbook;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TextbookController extends Controller
{
    public function index()
    {
        $textbooks = Textbook::with('student', 'issuedBy', 'receivedBy')->orderBy('book_name')->get();
        $count_textbooks = Textbook::count();
        $count_returned = Textbook::where('status', 'returned')->count();
        $count_lost = Textbook::where('status', 'lost')->count();

        return view('admin.textbooks.index', compact('textbooks', 'count_textbooks', 'count_returned', 'count_lost'));
    }

    public function create()
    {
        $students = Student::orderBy('first_name')->get();

        return view('admin.textbooks.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'book_name' => 'required|string|max:180',
            'book_number' => 'required|string|max:180',
            'date_issued' => 'nullable|date',
            'date_returned' => 'nullable|date|after:date_issued',
            'status' => ['required', Rule::in(Textbook::STATUSES)],
            'student_id' => 'required|exists:students,id',
        ]);

        Textbook::create($validated_data);

        return redirect()->route('textbooks.index')->with('success', 'Textbook has been added.');
    }

    public function show(Textbook $textbook)
    {
        //
    }

    public function edit(Textbook $textbook)
    {
        $students = Student::orderBy('first_name')->get();

        return view('admin.textbooks.edit', compact('students', 'textbook'));
    }

    public function update(Request $request, Textbook $textbook)
    {
        $validated_data = $request->validate([
            'book_name' => 'required|string|max:180',
            'book_number' => 'required|string|max:180',
            'status' => ['required', Rule::in(Textbook::STATUSES)],
            'date_issued' => 'nullable|date',
            'date_returned' => 'nullable|date|after:date_issued',
            'student_id' => 'required|exists:students,id',
        ]);

        $textbook->update($validated_data);

        return redirect()->route('textbooks.index')->with('success', 'Textbook has been updated.');
    }

    public function destroy(Textbook $textbook)
    {
        $textbook->delete();

        return redirect()->route('textbooks.index')->with('success', 'Textbook has been deleted.');
    }
}
