<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::orderBy('name')->get();
        $count_subjects = count($subjects);

        return view('admin.subjects.index', compact('subjects','count_subjects'));
    }

    public function create()
    {
        return view('admin.subjects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string' , 'max:80', 'unique:subjects,name'],
            'acronym' => ['nullable', 'string' , 'max:10'],
            'code' => ['nullable', 'string' , 'max:30', 'unique:subjects,code'],
        ]);

        Subject::create($validated);

        return redirect(route('subjects.index'))->with('success','Subject has been added');
    }

    public function edit(Subject $subject)
    {
        return view('admin.subjects.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name' => ['required', 'string' , 'max:80', 'unique:subjects,name,'.$subject->id],
            'acronym' => ['nullable', 'string' , 'max:10'],
            'code' => ['nullable', 'string' , 'max:30', 'unique:subjects,code,'.$subject->id],
        ]);

        $subject->update($validated);

        return redirect(route('subjects.index'))->with('success','Subject has been updated');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect(route('subjects.index'))->with('success','Subject has been deleted');
    }
}
