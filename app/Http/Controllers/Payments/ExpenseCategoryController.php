<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Payments\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $expense_categories = ExpenseCategory::orderBy('name')->get();
        $count_expense_categories = $expense_categories->count();

        return view('admin.payments.expense-categories.index', compact('count_expense_categories', 'expense_categories'));
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'name' => 'required|string|min:2|max:80',
            'description' => 'nullable|string|min:2|max:255',
        ]);

        ExpenseCategory::create($validated_data);

        return redirect()->back()->with('success', 'Category has been added.');
    }

    public function edit(ExpenseCategory $expense_category)
    {
        return view('admin.payments.expense-categories.edit', compact('expense_category'));
    }

    public function update(Request $request, ExpenseCategory $expense_category)
    {
        $validated_data = $request->validate([
            'name' => 'required|string|min:2|max:80',
            'description' => 'nullable|string|min:2|max:255',
        ]);

        $expense_category->update($validated_data);

        return redirect()->route('expense-categories.index')->with('success', 'Category has ben updated.');
    }

    public function destroy(ExpenseCategory $expense_category)
    {
        $expense_category->delete();

        return redirect()->route('expense-categories.index')->with('success', 'Category has ben deleted.');
    }
}
