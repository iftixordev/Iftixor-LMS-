<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;
        $payments = $student ? $student->payments()->latest()->paginate(10) : collect();
        
        return view('student.payments', compact('payments'));
    }
    
    public function store(Request $request)
    {
        try {
            $request->validate([
                'amount' => 'required|numeric|min:1000',
                'payment_method' => 'required|string'
            ]);
            
            $student = Auth::user()->student;
            
            if (!$student) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Student ma\'lumotlari topilmadi'
                ], 404);
            }
            
            $payment = Payment::create([
                'student_id' => $student->id,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'payment_date' => now(),
                'status' => 'completed',
                'description' => 'Online to\'lov',
                'receipt_number' => 'PAY-' . date('Y') . '-' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT)
            ]);
            
            return response()->json([
                'success' => true, 
                'message' => 'To\'lov muvaffaqiyatli amalga oshirildi!',
                'payment_id' => $payment->id
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Ma\'lumotlar noto\'g\'ri kiritilgan',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Payment error: ' . $e->getMessage());
            return response()->json([
                'success' => false, 
                'message' => 'To\'lov jarayonida xatolik yuz berdi. Qaytadan urinib ko\'ring.'
            ], 500);
        }
    }
}
