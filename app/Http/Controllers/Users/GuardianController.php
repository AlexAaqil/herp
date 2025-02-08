<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Guardian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GuardianController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'guardian_first_name' => 'required|string|max:80',
            'guardian_last_name' => 'required|string|max:100',
            'guardian_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:guardians,email'],
            'phone_number' => ['required', 'max:30', 'unique:guardians,phone_number','regex:/^(07|01)\d{8,}$/'],
            'phone_other' => ['nullable', 'max:30','regex:/^(07|01)\d{8,}$/'],
            'address' => ['nullable', 'string'],
        ], [
            'guardian_first_name.required' => 'You must enter a first name',
            'guardian_last_name.required' => 'You must enter a last name',
            'email.required' => 'You must enter an email',
            'phone_number.required' => 'You must enter a unique phone number',
            'phone_number.regex' => 'The phone number must start with 07 or 01',
            'phone_other.regex' => 'The phone number must start with 07 or 01',
            'phone_number.unique' => 'That phone number exists. Use another one.',
        ]);

        DB::transaction(function () use ($request, $validated_data) {
            $image_path = null;
            if ($request->hasFile('guardian_image')) {
                $image_path = $request->file('guardian_image')->store('guardians', 'public');
            }

            $guardian = Guardian::create([
                'first_name' => $validated_data['guardian_first_name'],
                'last_name' => $validated_data['guardian_last_name'],
                'image' => $image_path,
                'email' => $validated_data['email'],
                'phone_number' => $validated_data['phone_number'],
                'phone_other' => $validated_data['phone_other'],
                'address' => $validated_data['address'],
            ]);
        });

        return redirect()->back()->with('success', 'Guardian has been added.');
    }

    public function show(Guardian $guardian)
    {
        //
    }

    public function edit(Guardian $guardian)
    {
        //
    }

    public function update(Request $request, Guardian $guardian)
    {
        $validated_data = $request->validate([
            'guardian_first_name' => 'required|string|max:80',
            'guardian_last_name' => 'required|string|max:100',
            'guardian_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:guardians,email,'.$guardian->id],
            'phone_number' => ['required', 'max:30','regex:/^(07|01)\d{8,}$/','unique:guardians,phone_number,'.$guardian->id],
            'phone_other' => ['nullable', 'max:30','regex:/^(07|01)\d{8,}$/'],
            'address' => ['nullable', 'string'],
        ], [
            'guardian_first_name.required' => 'You must enter a first name',
            'guardian_last_name.required' => 'You must enter a last name',
            'email.required' => 'You must enter an email',
            'phone_number.required' => 'You must enter a unique phone number',
            'phone_number.regex' => 'The phone number must start with 07 or 01',
            'phone_other.regex' => 'The phone number must start with 07 or 01',
            'phone_number.unique' => 'That phone number exists. Use another one.',
        ]);

        DB::transaction(function () use ($request, $guardian, $validated_data) {
            if ($request->hasFile('guardian_image')) {
                if ($guardian->image && Storage::disk('public')->exists($guardian->image)) {
                    Storage::disk('public')->delete($guardian->image);
                }
                $image_path = $request->file('guardian_image')->store('guardians', 'public');
            } else {
                $image_path = $guardian->image;
            }

            $guardian->update([
                'first_name' => $validated_data['guardian_first_name'],
                'last_name' => $validated_data['guardian_last_name'],
                'image' => $image_path,
                'email' => $validated_data['email'],
                'phone_number' => $validated_data['phone_number'],
                'phone_other' => $validated_data['phone_other'],
                'address' => $validated_data['address'],
            ]);
        });

        return redirect()->route('students.index')->with('success', 'Guardian has been updated.');
    }

    public function destroy(Guardian $guardian)
    {
        DB::transaction(function () use ($guardian) {
            if ($guardian->image && Storage::disk('public')->exists($guardian->image)) {
                Storage::disk('public')->delete($guardian->image);
            }

            $guardian->guardians()->detach();

            $guardian->delete();
        });

        return redirect()->route('students.index')->with('success', 'Guardian has been deleted.');
    }
}
