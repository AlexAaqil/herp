<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Payments\Expense;
use App\Models\Payments\ExpenseCategory;
use App\Models\Payments\ExpenseRecipient;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with('category', 'recipient')->orderBy('date')->get();
        $count_expenses = $expenses->count();

        return view('admin.payments.expenses.index', compact('count_expenses', 'expenses'));
    }

    public function create()
    {
        $categories = ExpenseCategory::orderBy('name')->get();
        $recipients = ExpenseRecipient::orderBy('name')->get();

        return view('admin.payments.expenses.create', compact('categories', 'recipients'));
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'expense_recipient_id' => 'required|exists:expense_recipients,id',
            'expense_category_id' => 'required|exists:expense_categories,id',
            'amount_paid' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:cash,bank,mpesa,cheque',
            'reference_number' => 'nullable|string|max:255',
            'payment_status' => 'nullable|string|in:paid,pending,failed',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        Expense::create($validated_data);

        return redirect()->route('expenses.index')->with('success', 'Expense has been added.');
    }

    public function edit(Expense $expense)
    {
        $categories = ExpenseCategory::orderBy('name')->get();
        $recipients = ExpenseRecipient::orderBy('name')->get();

        return view('admin.payments.expenses.edit', compact('categories', 'expense', 'recipients'));
    }

    public function update(Request $request, Expense $expense)
    {
        $validated_data = $request->validate([
            'expense_recipient_id' => 'required|exists:expense_recipients,id',
            'expense_category_id' => 'required|exists:expense_categories,id',
            'amount_paid' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:cash,bank,mpesa,cheque',
            'reference_number' => 'nullable|string|max:255',
            'payment_status' => 'nullable|string|in:paid,pending,failed',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        $expense->fill($validated_data)->save();

        return redirect()->route('expenses.index')->with('success', 'Expense has been updated.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'Expense has been deleted.');
    }
}
