<?php

namespace App\Http\Controllers;

use App\Models\Dorm;
use Illuminate\Http\Request;

class DormController extends Controller
{
    public function index()
    {
        $dorms = Dorm::orderBy('name')->get();
        $count_dorms = count($dorms);

        return view('admin.dorms.index', compact('dorms', 'count_dorms'));
    }

    public function create()
    {
        return view('admin.dorms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:80', 'unique:dorms,name'],
        ]);

        Dorm::create($validated);

        return redirect(route('dorms.index'))->with('success', 'Dorm has been added');
    }

    public function edit(Dorm $dorm)
    {
        return view('admin.dorms.edit', compact('dorm'));
    }

    public function update(Request $request, Dorm $dorm)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:80', 'unique:dorms,name,'.$dorm->id],
        ]);

        $dorm->update($validated);

        return redirect(route('dorms.index'))->with('success', 'Dorm has been updated');
    }

    public function destroy(Dorm $dorm)
    {
        $dorm->delete();

        return redirect(route('dorms.index'))->with('success', 'Dorm has been deleted');
    }
}
