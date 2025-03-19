<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::first();

        return view('admin.settings.index', compact('settings'));
    }

    public function edit()
    {
        $settings = Setting::first(); // Ensure only one settings record exists

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'school_name' => 'required|string|max:255',
            'school_acronym' => 'required|string|max:50',
            'school_address' => 'required|string|max:255',
            'school_phone_number' => 'required|string|max:20',
            'school_phone_other' => 'nullable|string|max:20',
            'school_email' => 'required|email|max:100',
            'current_year' => 'nullable|integer|min:2000|max:2099',
            'current_term' => 'nullable|integer|min:1|max:3',
            'term_begins' => 'nullable|date',
            'term_ends' => 'nullable|date|after_or_equal:term_begins',
            'principal_stamp' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bursar_stamp' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'storekeeper_stamp' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $settings = Setting::firstOrCreate([]);

            $stamps = ['principal_stamp', 'bursar_stamp', 'storekeeper_stamp'];

            foreach ($stamps as $stamp) {
                if ($request->hasFile($stamp)) {
                    // Retrieve raw path from database before updating
                    $oldImagePath = $settings->getRawOriginal($stamp);

                    // Delete old image if it exists
                    if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                        Storage::disk('public')->delete($oldImagePath);
                    }

                    // Upload new image
                    $fileName = time() . "_{$stamp}." . $request->$stamp->extension();
                    $path = $request->$stamp->storeAs('stamps', $fileName, 'public');
                    $validatedData[$stamp] = $path;
                }
            }

            $settings->update($validatedData);

            DB::commit();

            return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('settings.index')->with('error', 'Failed to update settings.');
        }
    }

    public function destroy()
    {
        $settings = Setting::first();

        if ($settings) {
            $settings->delete();
        }

        return redirect()->route('settings.index')->with('success', 'Settings have been deleted.');
    }
}
