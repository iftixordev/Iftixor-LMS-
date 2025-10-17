<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coin;
use App\Models\ShopItem;
use App\Models\Student;
use App\Models\Purchase;
use Illuminate\Http\Request;

class GamificationController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_coins_earned' => Coin::where('type', 'earned')->sum('amount'),
            'total_coins_spent' => Coin::where('type', 'spent')->sum('amount'),
            'active_students' => Student::whereHas('coins')->count(),
            'shop_items' => ShopItem::where('is_active', true)->count(),
            'pending_purchases' => Purchase::where('status', 'pending')->count(),
        ];

        $topStudents = Student::withSum(['coins as earned' => function($q) {
            $q->where('type', 'earned');
        }], 'amount')
        ->withSum(['coins as spent' => function($q) {
            $q->where('type', 'spent');
        }], 'amount')
        ->get()
        ->map(function($student) {
            $student->balance = ($student->earned ?? 0) - ($student->spent ?? 0);
            return $student;
        })
        ->sortByDesc('balance')
        ->take(10);

        $recentTransactions = Coin::with('student')->latest()->take(10)->get();

        return view('admin.gamification.dashboard', compact('stats', 'topStudents', 'recentTransactions'));
    }

    public function addCoins(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|integer|min:1',
            'reason' => 'required|in:attendance,homework,grade,referral,bonus',
            'description' => 'nullable|string|max:255',
        ]);

        Coin::addCoins(
            $validated['student_id'],
            $validated['amount'],
            $validated['reason'],
            $validated['description']
        );

        return redirect()->back()->with('success', 'Coinlar muvaffaqiyatli qo\'shildi.');
    }

    public function shop()
    {
        try {
            $items = ShopItem::latest()->paginate(12);
            return view('admin.gamification.shop', compact('items'));
        } catch (\Exception $e) {
            $items = collect()->paginate();
            return view('admin.gamification.shop', compact('items'));
        }
    }

    public function createShopItem()
    {
        return view('admin.gamification.create-item');
    }

    public function storeShopItem(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'coin_price' => 'required|integer|min:1',
                'stock' => 'required|integer|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($request->hasFile('image')) {
                $validated['image_path'] = $request->file('image')->store('shop', 'public');
            }

            ShopItem::create($validated);
            return redirect()->route('admin.gamification.shop')->with('success', 'Mahsulot muvaffaqiyatli qo\'shildi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xatolik: ' . $e->getMessage())->withInput();
        }
    }

    public function showShopItem(ShopItem $item)
    {
        if (request()->expectsJson()) {
            return response()->json($item);
        }
        
        return view('admin.gamification.show-item', compact('item'));
    }

    public function updateShopItem(Request $request, ShopItem $item)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'coin_price' => 'required|integer|min:1',
                'stock' => 'required|integer|min:0',
                'is_active' => 'boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($request->hasFile('image')) {
                $validated['image_path'] = $request->file('image')->store('shop', 'public');
            }

            $item->update($validated);
            return redirect()->route('admin.gamification.shop')->with('success', 'Mahsulot yangilandi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xatolik: ' . $e->getMessage())->withInput();
        }
    }

    public function storeReward(Request $request)
    {
        try {
            $validated = $request->validate([
                'type' => 'required|in:achievement,badge,certificate,discount',
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'required_coins' => 'nullable|integer|min:0',
                'discount_percent' => 'nullable|integer|min:0|max:100',
            ]);

            // Create reward logic here
            return redirect()->route('admin.gamification.shop')->with('success', 'Namudlar muvaffaqiyatli yaratildi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xatolik: ' . $e->getMessage())->withInput();
        }
    }

    public function purchases()
    {
        $purchases = Purchase::with(['student', 'shopItem'])->latest()->paginate(20);
        return view('admin.gamification.purchases', compact('purchases'));
    }

    public function updatePurchaseStatus(Purchase $purchase, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,delivered,cancelled'
        ]);

        $purchase->update($validated);
        return redirect()->back()->with('success', 'Holat yangilandi.');
    }
}
