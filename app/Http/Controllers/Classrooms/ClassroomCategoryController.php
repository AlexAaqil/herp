<?php

namespace App\Http\Controllers\Classrooms;

use App\Http\Controllers\Controller;
use App\Models\Classrooms\ClassroomCategory;
use Illuminate\Http\Request;

class ClassroomCategoryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'classroom_category_name' => ['required', 'string', 'max:100', 'unique:classroom_categories,name'],
        ]);

        ClassroomCategory::create([
            'name' => $request->classroom_category_name,
        ]);

        return redirect(route('classrooms.create'))->with('success', 'Category has been added.');
    }

    public function edit(ClassroomCategory $classroom_category)
    {
        return view('admin.classes.classroom-categories.edit', compact('classroom_category'));
    }

    public function update(Request $request, ClassroomCategory $classroom_category)
    {
        $validated = $request->validate([
            'classroom_category_name' => ['required', 'string', 'max:100', 'unique:classroom_categories,name,'.$classroom_category->id],
        ]);

        $classroom_category->update([
            'name' => $request->classroom_category_name,
        ]);

        return redirect(route('classrooms.index'))->with('success', 'Category has been updated.');
    }

    public function destroy(ClassroomCategory $classroom_category)
    {
        $classroom_category->delete();

        return redirect(route('classrooms.index'))->with('success', 'Category has been deleted.');
    }
}
