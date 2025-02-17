<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LeaveController extends Controller
{
    public function index()
    {
        $user_level = Auth::user()->user_level;

        if($user_level != 0 && $user_level != 1) {
            $leaves = Leave::where('user_id', Auth::id())->orderByRaw("FIELD(response, 'pending', 'approved', 'rejected')")->latest()->get();
        } else {
            $leaves = Leave::with('user')->orderByRaw("FIELD(response, 'pending', 'approved', 'rejected')")->latest()->get();
        }

        $count_leaves = count($leaves);
        $count_unread = $leaves->where('status', 0)->count();
        $count_notanswered = $leaves->where('response', 'pending')->count();

        return view('admin.leaves.leaves.index', compact('leaves', 'count_leaves', 'count_unread', 'count_notanswered'));
    }

    public function create()
    {
        return view('admin.leaves.leaves.create');
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'category' => ['required', Rule::in(Leave::CATEGORIES)],
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'comment' => 'required|string',
        ]);

        $validated_data['user_id'] = Auth::id();

        Leave::create($validated_data);

        return redirect()->route('leaves.index')->with('success', 'Leave application has been sent.');
    }

    public function edit(Leave $leave)
    {
        if ($leave->user_id !== Auth::id() && Auth::user()->user_level > 1) {
            abort(403, 'What are you trying to do?');
        }

        if(Auth::user()->user_level === 1 || (Auth::user()->user_level === 0 && $leave->status == 0)) {
            $leave->update(['status' => 1]);
        }
        
        return view('admin.leaves.leaves.edit', compact('leave'));
    }

    public function update(Request $request, Leave $leave)
    {
        // Validate the request data
        $validated_data = $request->validate([
            'comment' => 'sometimes|required|string',
            'from_date' => 'sometimes|required|date',
            'to_date' => 'sometimes|required|date|after_or_equal:from_date',
            'response' => ['sometimes', 'required', Rule::in(Leave::RESPONSES)],
            'category' => ['sometimes', 'required', Rule::in(Leave::CATEGORIES)],
        ]);
    
        if ($request->user()->can('view-as-admin')) {
            $leave->update($validated_data);
        } else {
            if ($leave->response === 'pending') {
                $leave->update([
                    'category' => $validated_data['category'],
                    'from_date' => $validated_data['from_date'],
                    'to_date' => $validated_data['to_date'],
                    'comment' => $validated_data['comment'],
                ]);
            } else {
                return redirect()->back()->with('error', 'You can only update leave details when the response is pending.');
            }
        }
    
        return redirect()->route('leaves.index')->with('success', 'Leave has been updated');
    }

    public function destroy(Leave $leave)
    {
        $leave->delete();

        return redirect()->route('leaves.index')->with('success', 'Leave has been deleted.');
    }
}
