<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Payments\ExpenseRecipient;
use Illuminate\Http\Request;

class ExpenseRecipientController extends Controller
{
    public function index()
    {
        $recipients = ExpenseRecipient::orderBy('name')->get();
        $count_recipients = $recipients->count();

        return view('admin.payments.expense-recipients.index', compact('count_recipients', 'recipients'));
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255'],
            'phone_number' => ['required', 'max:30', 'unique:expense_recipients,phone_number', 'regex:/^(07|01)\d{8,}$/'],
            'company_name' => 'nullable|string',
        ], [
            'phone_number.regex' => 'The phone number must start with 07 or 01.',
            'phone_number.unique' => 'That phone number has been used.',
        ]);

        ExpenseRecipient::create($validated_data);

        return redirect()->route('expense-recipients.index')->with('success', 'Recipient has been added.');
    }

    public function edit(ExpenseRecipient $expense_recipient)
    {
        return view('admin.payments.expense-recipients.edit', compact('expense_recipient'));
    }

    public function update(Request $request, ExpenseRecipient $expense_recipient)
    {
        $validated_data = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255'],
            'phone_number' => ['required', 'max:30', 'regex:/^(07|01)\d{8,}$/', 'unique:expense_recipients,phone_number,' . $expense_recipient->id],
            'company_name' => 'nullable|string',
        ], [
            'phone_number.regex' => 'The phone number must start with 07 or 01.',
            'phone_number.unique' => 'That phone number has been used.',
        ]);

        $expense_recipient->update($validated_data);

        return redirect()->route('expense-recipients.index')->with('success', 'Recipient has been updated.');
    }

    public function destroy(ExpenseRecipient $expense_recipient)
    {
        $expense_recipient->delete();

        return redirect()->route('expense-recipients.index')->with('success', 'Recipient has been deleted.');
    }
}
