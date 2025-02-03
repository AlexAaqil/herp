<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('first_name')->get();
        $count_users = $users->count();
        $count_admins = $users->whereIn('user_level', [0, 1])->count();
        $count_inactive = $users->where('user_status', 0)->count();

        return view('admin.users.index', compact('users', 'count_users', 'count_admins', 'count_inactive'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:80'],
            'last_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone_main' => ['required', 'max:30', 'unique:users,phone_main','regex:/^(07|01)\d{8,}$/'],
            'user_level' => ['required', 'exists:user_levels,id'],
            'emp_code' => ['nullable'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ], [
            'phone_main.regex' => 'The phone number must start with 07 or 01',
            'phone_main.unique' => 'That phone number has been used.',
        ]);

        $generated_password = $request->password ?? Str::random(8);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_main' => $request->phone_main ?? 254746055487,
            'user_level' => $request->user_level,
            'emp_code' => $request->emp_code,
            'password' => Hash::make($request->password ?? $generated_password),
        ]);

        Mail::to($user->email)->send(new WelcomeEmail($user, $generated_password ?? $request->password));

        return redirect(route('users.index'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'user_level' => ['required', 'in:'.implode(',', array_keys(User::USERLEVELS))],
            'user_status' => ['required', 'in:'.implode(',', array_keys(User::USERSTATUS))],
        ]);

        $updated_fields = [
            'user_level' => $validated['user_level'],
            'user_status' => $validated['user_status'],
        ];

        if (!empty($validated['password'])) {
            $updated_fields['password'] = $validated['password'];
        }

        $user->update($updated_fields);

        return redirect(route('users.index'))->with('success', 'User details have been updated.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect(route('users.index'))->with('success', 'User has been deleted');
    }
}
