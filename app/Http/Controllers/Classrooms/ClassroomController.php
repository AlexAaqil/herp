<?php

namespace App\Http\Controllers\Classrooms;

use App\Http\Controllers\Controller;
use App\Models\Classrooms\Classroom;
use App\Models\Classrooms\ClassroomCategory;
use App\Models\User;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::with('classroomCategory', 'classTeacher')->get();
        $grouped_classrooms = $classrooms->groupBy('classroom_category_id');
        $classroom_categories = ClassroomCategory::all();

        $grouped_classrooms = $classroom_categories->mapWithKeys(function ($category) use ($grouped_classrooms) {
            return [
                $category->id => $grouped_classrooms->get($category->id, collect())
            ];
        });

        $count_classrooms = count($classrooms);
        $count_classroom_categories = count($classroom_categories);
        

        return view('admin.classes.classrooms.index', compact('grouped_classrooms', 'count_classrooms', 'count_classroom_categories'));
    }

    public function create()
    {
        $classroom_categories = ClassroomCategory::orderBy('name')->get();
        $teachers = User::where('user_level', 2)->where('user_status', 1)->get();

        return view('admin.classes.classrooms.create', compact('classroom_categories', 'teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:classrooms,name'],
            'classroom_category_id' => ['required', 'numeric', 'exists:classroom_categories,id'],
            'class_teacher_id' => ['nullable', 'numeric', 'exists:users,id'],
        ], [
            'classroom_category_id.required' => 'Category has to be selected.'
        ]);

        Classroom::create($validated);

        return redirect(route('classrooms.index'))->with('success', 'Classroom has been added.');
    }

    public function edit(Classroom $classroom)
    {
        $classroom_categories = ClassroomCategory::orderBy('name')->get();
        $teachers = User::where('user_level', 2)->where('user_status', 1)->get();

        return view('admin.classes.classrooms.edit', compact('classroom', 'classroom_categories', 'teachers'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:classrooms,name,'.$classroom->id],
            'classroom_category_id' => ['required', 'numeric', 'exists:classroom_categories,id'],
            'class_teacher_id' => ['nullable', 'numeric', 'exists:users,id'],
        ], [
            'classroom_category_id.required' => 'Category has to be selected.'
        ]);

        $classroom->update($validated);

        return redirect(route('classrooms.index'))->with('success', 'Classroom has been updated.');
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();

        return redirect(route('classrooms.index'))->with('success', 'Classroom has been deleted.');
    }
}
