<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FinanceController extends Controller
{
    public function index()
    {
        $stats = [
            'today_revenue' => Payment::whereDate('payment_date', today())->sum('amount'),
            'monthly_revenue' => Payment::whereMonth('payment_date', now()->month)->sum('amount'),
            'yearly_revenue' => Payment::whereYear('payment_date', now()->year)->sum('amount'),
            'pending_payments' => Payment::where('status', 'pending')->count(),
        ];

        $recent_payments = Payment::with('student')->latest()->take(10)->get();
        
        return view('admin.finance.index', compact('stats', 'recent_payments'));
    }

    public function payments(Request $request)
    {
        $query = Payment::with('student');
        $selectedStudent = null;

        // Agar student_id parametri berilgan bo'lsa
        if ($request->filled('student_id')) {
            $selectedStudent = Student::find($request->student_id);
        }

        if ($request->filled('student_search')) {
            $search = $request->student_search;
            $query->whereHas('student', function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('payment_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('payment_date', '<=', $request->date_to);
        }

        $payments = $query->latest('payment_date')->paginate(20);
        $students = Student::where('status', 'active')
            ->select('id', 'first_name', 'last_name', 'student_id', 'phone', 'parent_name')
            ->get();
        
        return view('admin.finance.payments', compact('payments', 'students', 'selectedStudent'));
    }

    public function storePayment(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0',
            'payment_type' => 'required|string',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,card,transfer,online',
            'status' => 'required|in:completed,pending',
            'notes' => 'nullable|string',
        ]);

        $originalAmount = $validated['amount'];
        $discountPercent = $validated['discount_percent'] ?? 0;
        $discountAmount = ($originalAmount * $discountPercent) / 100;
        $finalAmount = $originalAmount - $discountAmount;

        $payment = Payment::create([
            'student_id' => $validated['student_id'],
            'amount' => $finalAmount,
            'original_amount' => $originalAmount,
            'discount_percent' => $discountPercent,
            'payment_method' => $validated['payment_method'],
            'payment_date' => $validated['payment_date'],
            'status' => $validated['status'],
            'notes' => $validated['notes'],
            'receipt_number' => 'PAY-' . date('Y') . '-' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT),
            'description' => 'Admin to\'lov - ' . $validated['payment_type']
        ]);

        // Agar request dan student sahifasidan kelgan bo'lsa, o'sha sahifaga qaytarish
        if ($request->has('redirect_to_student')) {
            return redirect()->route('admin.students.show', $validated['student_id'])
                ->with('success', 'To\'lov muvaffaqiyatli qabul qilindi.');
        }
        
        return redirect()->route('admin.finance.payments')->with('success', 'To\'lov muvaffaqiyatli qabul qilindi.');
    }

    public function editPayment(Payment $payment)
    {
        $payment->load('student');
        
        // Return payment data with proper structure
        return response()->json([
            'id' => $payment->id,
            'student_id' => $payment->student_id,
            'amount' => $payment->amount,
            'original_amount' => $payment->original_amount ?? $payment->amount,
            'discount_percent' => $payment->discount_percent ?? 0,
            'payment_method' => $payment->payment_method,
            'payment_date' => $payment->payment_date->format('Y-m-d'),
            'status' => $payment->status,
            'notes' => $payment->notes,
            'student' => [
                'id' => $payment->student->id,
                'first_name' => $payment->student->first_name,
                'last_name' => $payment->student->last_name,
                'student_id' => $payment->student->student_id,
                'phone' => $payment->student->phone,
                'parent_name' => $payment->student->parent_name
            ]
        ]);
    }

    public function updatePayment(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0',
            'payment_type' => 'required|string',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,card,transfer,online',
            'status' => 'required|in:completed,pending',
            'notes' => 'nullable|string',
        ]);

        $originalAmount = $validated['amount'];
        $discountPercent = $validated['discount_percent'] ?? 0;
        $discountAmount = ($originalAmount * $discountPercent) / 100;
        $finalAmount = $originalAmount - $discountAmount;

        $payment->update([
            'student_id' => $validated['student_id'],
            'amount' => $finalAmount,
            'original_amount' => $originalAmount,
            'discount_percent' => $discountPercent,
            'payment_method' => $validated['payment_method'],
            'payment_date' => $validated['payment_date'],
            'status' => $validated['status'],
            'notes' => $validated['notes'],
            'description' => 'Admin to\'lov - ' . $validated['payment_type']
        ]);

        // Agar request dan student sahifasidan kelgan bo'lsa, o'sha sahifaga qaytarish
        if ($request->has('redirect_to_student')) {
            return redirect()->route('admin.students.show', $validated['student_id'])
                ->with('success', 'To\'lov muvaffaqiyatli yangilandi.');
        }
        
        return redirect()->route('admin.finance.payments')->with('success', 'To\'lov muvaffaqiyatli yangilandi.');
    }

    public function deletePayment(Payment $payment)
    {
        try {
            $studentId = $payment->student_id;
            $payment->delete();
            
            // AJAX request uchun JSON response
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'To\'lov muvaffaqiyatli o\'chirildi.'
                ]);
            }
            
            // Agar referer student sahifasidan kelgan bo'lsa, o'sha sahifaga qaytarish
            if (str_contains(request()->headers->get('referer', ''), '/students/')) {
                return redirect()->route('admin.students.show', $studentId)
                    ->with('success', 'To\'lov muvaffaqiyatli o\'chirildi.');
            }
            
            return redirect()->route('admin.finance.payments')->with('success', 'To\'lov muvaffaqiyatli o\'chirildi.');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'To\'lovni o\'chirishda xatolik yuz berdi.'
                ], 500);
            }
            
            return redirect()->back()->with('error', 'To\'lovni o\'chirishda xatolik yuz berdi.');
        }
    }

    public function discounts()
    {
        $discounts = \App\Models\Discount::latest()->paginate(20);
        return view('admin.finance.discounts', compact('discounts'));
    }

    public function storeDiscount(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'usage_limit' => 'nullable|integer|min:1',
        ]);

        \App\Models\Discount::create($validated);
        return redirect()->route('admin.finance.discounts')->with('success', 'Chegirma yaratildi.');
    }

    public function receipt(Payment $payment)
    {
        $payment->load('student');
        return view('admin.finance.receipt', compact('payment'));
    }

    public function debtors()
    {
        $debtors = Student::whereDoesntHave('payments', function($q) {
            $q->where('payment_date', '>=', now()->subDays(30));
        })->where('status', 'active')->get();
        
        return view('admin.finance.debtors', compact('debtors'));
    }

    public function transactions(Request $request)
    {
        $query = Transaction::with(['student', 'teacher']);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('transaction_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('transaction_date', '<=', $request->date_to);
        }

        $transactions = $query->latest('transaction_date')->paginate(20);
        
        return view('admin.finance.transactions', compact('transactions'));
    }

    public function storeTransaction(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'category' => 'required|in:student_payment,teacher_salary,rent,utilities,marketing,supplies,other',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'transaction_date' => 'required|date',
            'student_id' => 'nullable|exists:students,id',
            'teacher_id' => 'nullable|exists:teachers,id',
            'reference_number' => 'nullable|string|max:255',
        ]);

        Transaction::create($validated);
        return redirect()->route('admin.finance.transactions')->with('success', 'Tranzaksiya qo\'shildi.');
    }

    public function financialReport(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth());
        $endDate = $request->get('end_date', now()->endOfMonth());

        $income = Transaction::where('type', 'income')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');

        $expenses = Transaction::where('type', 'expense')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->sum('amount');

        $incomeByCategory = Transaction::where('type', 'income')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->get();

        $expensesByCategory = Transaction::where('type', 'expense')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->get();

        $balance = $income - $expenses;

        return view('admin.finance.reports', compact(
            'income', 'expenses', 'balance', 'incomeByCategory', 
            'expensesByCategory', 'startDate', 'endDate'
        ));
    }

    public function reports()
    {
        $stats = [
            'daily_income' => Payment::whereDate('payment_date', today())->sum('amount'),
            'monthly_income' => Payment::whereMonth('payment_date', now()->month)->sum('amount'),
            'yearly_income' => Payment::whereYear('payment_date', now()->year)->sum('amount'),
            'pending_payments' => Payment::where('status', 'pending')->count(),
        ];

        $recent_payments = Payment::with('student')->latest()->take(10)->get();
        
        return view('admin.finance.reports', compact('stats', 'recent_payments'));
    }
}
