<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;


class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expense::latest()->paginate(10);
        return view('admin.expenses.index', compact('expenses'));
    }

    public function create()
    {
        return view('admin.expenses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:100',
            'amount'       => 'required|numeric',
            'expense_date' => 'required|date',
            'penerima'     => 'nullable|string|max:100',
            'note'         => 'nullable|string',
        ]);

        Expense::create($request->all());

        return redirect()->route('admin.expenses.index')
            ->with('success', 'Biaya berhasil ditambahkan.');
    }

    public function show(Expense $expense)
    {
        return view('admin.expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        return view('admin.expenses.edit', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'name'         => 'required|string|max:100',
            'amount'       => 'required|numeric',
            'expense_date' => 'required|date',
            'penerima'     => 'nullable|string|max:100',
            'sumber'       => 'required|string|max:100',
            'note'         => 'nullable|string',
        ]);

        $expense->update($request->all());

        return redirect()->route('admin.expenses.index')
            ->with('success', 'Biaya berhasil diperbarui.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('admin.expenses.index')
            ->with('success', 'Biaya berhasil dihapus.');
    }
}
