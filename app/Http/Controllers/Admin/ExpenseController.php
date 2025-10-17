<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::latest()->paginate(20);
        $totalExpenses = Expense::sum('amount');
        $monthlyExpenses = Expense::whereMonth('expense_date', now()->month)->sum('amount');
        return view('admin.expenses.index', compact('expenses', 'totalExpenses', 'monthlyExpenses'));
    }

    public function create()
    {
        $categories = ['salary' => 'Maosh', 'rent' => 'Ijara', 'utilities' => 'Kommunal', 'supplies' => 'Jihozlar', 'marketing' => 'Marketing', 'other' => 'Boshqa'];
        return view('admin.expenses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'amount' => 'required|numeric|min:0',
                'category' => 'required|in:salary,rent,utilities,supplies,marketing,other',
                'expense_date' => 'required|date',
                'receipt_number' => 'nullable|string|max:100',
            ]);

            $validated['branch_id'] = session('current_branch_id');
            Expense::create($validated);
            return redirect()->route('admin.expenses.index')->with('success', 'Xarajat muvaffaqiyatli qo\'shildi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xatolik: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Expense $expense)
    {
        if (request()->expectsJson()) {
            return response()->json([
                'id' => $expense->id,
                'title' => $expense->title,
                'description' => $expense->description,
                'amount' => $expense->amount,
                'category' => $expense->category,
                'expense_date' => $expense->expense_date?->format('Y-m-d'),
                'receipt_number' => $expense->receipt_number,
            ]);
        }
        
        return view('admin.expenses.show', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'amount' => 'required|numeric|min:0',
                'category' => 'required|in:salary,rent,utilities,supplies,marketing,other',
                'expense_date' => 'required|date',
                'receipt_number' => 'nullable|string|max:100',
            ]);

            $expense->update($validated);
            return redirect()->route('admin.expenses.index')->with('success', 'Xarajat ma\'lumotlari yangilandi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xatolik: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('admin.expenses.index')->with('success', 'Xarajat o\'chirildi.');
    }
}
