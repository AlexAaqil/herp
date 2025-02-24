<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::orderByDesc('year')->orderBy('term')->get();
        $count_exams = count($exams);

        return view('admin.exams.exams.index', compact('exams', 'count_exams'));
    }

    public function create()
    {
        return view('admin.exams.exams.create');
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'name' => 'required|string|max:180',
            'year' => 'required|integer|min:1999|max:2050',
            'term' => 'required|integer|min:1|max:3',
        ]);

        Exam::create($validated_data);

        return redirect()->route('exams.index')->with('success', 'Exam has been added.');
    }

    public function edit(Exam $exam)
    {
        return view('admin.exams.exams.edit', compact('exam'));
    }

    public function update(Request $request, Exam $exam)
    {
        $validated_data = $request->validate([
            'name' => 'required|string|max:180',
            'year' => 'required|integer|min:1999|max:2050',
            'term' => 'required|integer|min:1|max:3',
        ]);

        $exam->update($validated_data);

        return redirect()->route('exams.index')->with('success', 'Exam has been updated.');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();

        return redirect()->route('exams.index')->with('success', 'Exam has been deleted.');
    }
}
