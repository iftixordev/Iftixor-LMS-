<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PhoneVerification;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PhoneAuthController extends Controller
{
    private $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function sendCode(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|regex:/^\+998[0-9]{9}$/'
        ]);

        $phone = $request->phone;
        
        try {
            // SMS orqali kod yuborish
            $result = $this->smsService->sendVerificationCode($phone);
            
            if (!$result['success']) {
                \Log::error('SMS Send Failed', ['phone' => $phone, 'result' => $result]);
                return response()->json(['error' => 'SMS yuborishda xatolik yuz berdi'], 400);
            }

            $requestId = uniqid('req_', true);
            
            // Ma'lumotni saqlash
            PhoneVerification::create([
                'phone' => $phone,
                'request_id' => $requestId,
                'code' => $result['code'],
                'expires_at' => Carbon::now()->addMinutes(5)
            ]);

            return response()->json([
                'message' => 'Tasdiqlash kodi SMS orqali yuborildi',
                'request_id' => $requestId
            ]);
        } catch (\Exception $e) {
            \Log::error('SMS Controller Exception', ['error' => $e->getMessage(), 'phone' => $phone]);
            return response()->json(['error' => 'Tizimda xatolik yuz berdi'], 500);
        }
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'code' => 'required|string|size:5',
            'request_id' => 'required|string'
        ]);

        $verification = PhoneVerification::where('phone', $request->phone)
            ->where('request_id', $request->request_id)
            ->where('is_verified', false)
            ->first();

        if (!$verification || $verification->isExpired()) {
            return response()->json(['error' => 'Kod yaroqsiz yoki muddati tugagan'], 400);
        }

        // Kodni tekshirish
        if ($verification->code !== $request->code) {
            return response()->json(['error' => 'Noto\'g\'ri kod'], 400);
        }

        // Kodni tasdiqlash
        $verification->update(['is_verified' => true]);

        // Foydalanuvchini topish yoki yaratish
        $user = User::where('phone', $request->phone)->first();
        
        if (!$user) {
            // Yangi foydalanuvchi uchun ma'lumotlarni to'ldirish sahifasiga yo'naltirish
            return response()->json([
                'message' => 'Telefon tasdiqlandi',
                'verified' => true,
                'new_user' => true,
                'phone' => $request->phone
            ]);
        }

        // Mavjud foydalanuvchini tizimga kiritish
        Auth::login($user);
        
        return response()->json([
            'message' => 'Muvaffaqiyatli kirildi',
            'verified' => true,
            'new_user' => false,
            'user' => $user
        ]);
    }

    public function completeRegistration(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'nullable|date'
        ]);

        // Telefon tasdiqlangan ekanligini tekshirish
        $verification = PhoneVerification::where('phone', $request->phone)
            ->where('is_verified', true)
            ->first();

        if (!$verification) {
            return response()->json(['error' => 'Telefon tasdiqlanmagan'], 400);
        }

        // Yangi foydalanuvchi yaratish
        $user = User::create([
            'phone' => $request->phone,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birth_date' => $request->birth_date,
            'role' => 'student',
            'is_active' => true
        ]);

        Auth::login($user);

        return response()->json([
            'message' => 'Ro\'yxatdan o\'tish muvaffaqiyatli yakunlandi',
            'user' => $user
        ]);
    }
}