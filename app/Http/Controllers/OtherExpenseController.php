<?php

namespace App\Http\Controllers;

use App\Models\OtherExpense;
use Illuminate\Http\Request;

class OtherExpenseController extends Controller
{
    /**
     * Display a listing of the other expenses.
     */
    public function index(Request $request)
    {
        $query = OtherExpense::query()->latest();

        if ($search = $request->get('search')) {
            $query->where('title', 'like', "%{$search}%");
        }
        $expenses = $query->paginate(10);
        return view('app.other_expenses.index', compact('expenses'));
    }


    /**
     * Show the form for creating a new expense.
     */
    public function create()
    {
        return view('app.other_expenses.create');
    }

    /**
     * Store a newly created expense in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'  => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        OtherExpense::create($validated);

        return redirect()->route('other-expenses.index')
            ->with('success', 'Expense created successfully.');
    }

    /**
     * Display the specified expense.
     */
    public function show(OtherExpense $otherExpense)
    {
        return view('app.other_expenses.show', compact('otherExpense'));
    }

    /**
     * Show the form for editing the specified expense.
     */
    public function edit(OtherExpense $otherExpense)
    {
        return view('app.other_expenses.edit', compact('otherExpense'));
    }

    /**
     * Update the specified expense in storage.
     */
    public function update(Request $request, OtherExpense $otherExpense)
    {
        $validated = $request->validate([
            'title'  => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        $otherExpense->update($validated);

        return redirect()->route('other-expenses.index')
            ->with('success', 'Expense updated successfully.');
    }

    /**
     * Remove the specified expense from storage.
     */
    public function destroy(OtherExpense $otherExpense)
    {
        $otherExpense->delete();

        return redirect()->route('other-expenses.index')
            ->with('success', 'Expense deleted successfully.');
    }
}
