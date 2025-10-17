<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Course;
use App\Models\LeadActivity;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        try {
            $currentBranchId = session('current_branch_id');
            $query = Lead::when($currentBranchId, fn($q) => $q->where('branch_id', $currentBranchId))->with('course');

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('source')) {
                $query->where('source', $request->source);
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }

            $leads = $query->latest()->paginate(15);
            $courses = Course::when($currentBranchId, fn($q) => $q->where('branch_id', $currentBranchId))->where('status', 'active')->get();
            
            return view('admin.leads.index', compact('leads', 'courses'));
        } catch (\Exception $e) {
            $leads = collect()->paginate();
            $courses = collect();
            return view('admin.leads.index', compact('leads', 'courses'));
        }
    }

    public function create()
    {
        $currentBranchId = session('current_branch_id');
        $courses = Course::when($currentBranchId, fn($q) => $q->where('branch_id', $currentBranchId))->where('status', 'active')->get();
        return view('admin.leads.create', compact('courses'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'email' => 'nullable|email|max:255',
                'address' => 'nullable|string',
                'course_id' => 'nullable|exists:courses,id',
                'source' => 'nullable|string',
                'notes' => 'nullable|string',
            ]);

            $validated['branch_id'] = session('current_branch_id');
            if (empty($validated['source'])) {
                $validated['source'] = 'manual';
            }
            
            Lead::create($validated);
            return redirect()->route('admin.leads.index')->with('success', 'Potensial mijoz muvaffaqiyatli qo\'shildi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xatolik: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Lead $lead)
    {
        if (request()->expectsJson()) {
            return response()->json([
                'id' => $lead->id,
                'first_name' => $lead->first_name,
                'last_name' => $lead->last_name,
                'phone' => $lead->phone,
                'email' => $lead->email,
                'address' => $lead->address,
                'course_id' => $lead->course_id,
                'status' => $lead->status,
                'source' => $lead->source,
                'notes' => $lead->notes,
            ]);
        }
        
        $lead->load('course');
        return view('admin.leads.show', compact('lead'));
    }

    public function edit(Lead $lead)
    {
        $currentBranchId = session('current_branch_id');
        $courses = Course::when($currentBranchId, fn($q) => $q->where('branch_id', $currentBranchId))->where('status', 'active')->get();
        return view('admin.leads.edit', compact('lead', 'courses'));
    }

    public function update(Request $request, Lead $lead)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'email' => 'nullable|email|max:255',
                'address' => 'nullable|string',
                'course_id' => 'nullable|exists:courses,id',
                'status' => 'required|in:new,contacted,interested,converted,lost',
                'notes' => 'nullable|string',
            ]);

            $lead->update($validated);
            return redirect()->route('admin.leads.index')->with('success', 'Mijoz ma\'lumotlari yangilandi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xatolik: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route('admin.leads.index')->with('success', 'Potensial mijoz o\'chirildi.');
    }

    public function addActivity(Request $request, Lead $lead)
    {
        $validated = $request->validate([
            'type' => 'required|in:call,email,sms,meeting,note',
            'subject' => 'nullable|string|max:255',
            'description' => 'required|string',
            'scheduled_at' => 'nullable|datetime',
        ]);

        $lead->activities()->create($validated);
        return redirect()->back()->with('success', 'Faoliyat qo\'shildi.');
    }

    public function completeActivity(LeadActivity $activity)
    {
        $activity->update(['completed' => true]);
        return redirect()->back()->with('success', 'Vazifa bajarildi.');
    }
}
