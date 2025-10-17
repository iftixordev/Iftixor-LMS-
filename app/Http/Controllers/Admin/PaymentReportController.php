<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Expense;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentReportController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();

        $stats = [
            'daily_income' => Payment::whereDate('payment_date', $today)->sum('amount'),
            'weekly_income' => Payment::where('payment_date', '>=', $thisWeek)->sum('amount'),
            'monthly_income' => Payment::where('payment_date', '>=', $thisMonth)->sum('amount'),
            'yearly_income' => Payment::whereYear('payment_date', now()->year)->sum('amount'),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'daily_expenses' => Expense::whereDate('expense_date', $today)->sum('amount'),
            'monthly_expenses' => Expense::where('expense_date', '>=', $thisMonth)->sum('amount'),
        ];

        $recent_payments = Payment::with('student')->latest()->take(10)->get();

        return view('admin.finance.reports', compact('stats', 'recent_payments'));
    }

    public function detailed(Request $request)
    {
        $query = Payment::with('student');

        if ($request->filled('date_from')) {
            $query->whereDate('payment_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('payment_date', '<=', $request->date_to);
        }

        if ($request->filled('type')) {
            if ($request->type == 'debt') {
                $query->where('debt_amount', '>', 0);
            } elseif ($request->type == 'advance') {
                $query->where('advance_amount', '>', 0);
            }
        }

        $payments = $query->latest('payment_date')->paginate(50);
        
        return view('admin.finance.detailed-report', compact('payments'));
    }
}
