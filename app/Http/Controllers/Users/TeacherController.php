<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Classrooms\Classroom;
use App\Models\Subject;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = User::where('user_level', 2)->with('classroomSubjects.classroom', 'classroomSubjects.subject')->orderBy('first_name')->get();
        $count_teachers = count($teachers);
        $count_inactive_teachers = $teachers->where('user_status', 0)->count();

        return view('admin.users.teachers.index', compact('teachers', 'count_teachers', 'count_inactive_teachers'));
    }

    public function edit(User $teacher)
    {
        $classrooms = Classroom::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        $teacher->load('classroomSubjects.classroom', 'classroomSubjects.subject');

        return view('admin.users.teachers.edit', compact('teacher', 'classrooms', 'subjects'));
    }

    public function update(User $teacher)
    {

    }
}
