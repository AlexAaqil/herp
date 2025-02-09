<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Models\Classrooms\Classroom;
use App\Models\Dorm;
use App\Models\Guardian;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth()->user();
        $count_users = User::whereNotIn('user_level', [2])
            ->where('user_status', 1)
            ->count();
        $count_teachers = User::where('user_level', 2)
            ->where('user_status', 1)
            ->count();
        $count_all_users = User::count();
        $count_all_students = Student::count();
        $count_guardians = Guardian::count();

        $count_classrooms = Classroom::count();
        $count_dorms = Dorm::count();

        $unread_messages = Message::latest()
            ->where('status', 0)
            ->take(5)
            ->get();
        $count_unread_messages = count($unread_messages);

        return view('dashboard.index', compact(
            'user',
            'count_users',
            'count_teachers',
            'count_all_users',
            'count_all_students',
            'count_guardians',

            'count_classrooms',
            'count_dorms',

            'unread_messages',
            'count_unread_messages',
        ));
    }
}
