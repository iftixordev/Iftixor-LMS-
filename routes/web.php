<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ModernDashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\GamificationController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\PaymentReportController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\StudentProgressController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\VideoLessonController;
use App\Services\SmsService;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'teacher':
                return redirect()->route('teacher.dashboard');
            case 'student':
                return redirect()->route('student.dashboard');
            case 'cashier':
            case 'receptionist':
                return redirect()->route('staff.dashboard');
            default:
                return redirect()->route('login');
        }
    }
    // Show public landing page with course info
    $courses = App\Models\Course::where('status', 'active')->take(6)->get();
    return view('welcome', compact('courses'));
})->name('welcome');

// Test SMS
Route::get('/test-sms', function () {
    $sms = new SmsService();
    $result = $sms->sendVerificationCode('+998901234567');
    return response()->json($result);
});

// YouTube Style Demo
Route::get('/youtube-demo', function () {
    return view('youtube-demo');
})->name('youtube-demo');

// Minimalist Demo
Route::get('/minimalist-demo', function () {
    return view('minimalist-demo');
})->name('minimalist-demo');

// Claude Admin Demo
Route::get('/claude-admin-demo', function () {
    return view('claude-admin-demo');
})->name('claude-admin-demo');

// Gemini Admin Demo
Route::get('/gemini-admin-demo', function () {
    return view('gemini-admin-demo');
})->name('gemini-admin-demo');

// Sidebar Slider Demo
Route::get('/sidebar-demo', function () {
    return view('sidebar-demo');
})->name('sidebar-demo');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/check-phone', [AuthController::class, 'checkPhone']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Telefon orqali autentifikatsiya
Route::get('/phone-login', function () {
    return view('auth.phone-login');
})->name('phone-login');

// Public Certificate Verification
Route::get('/verify-certificate', [CertificateController::class, 'verify'])->name('certificates.verify');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin', 'branch'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/modern-dashboard', [ModernDashboardController::class, 'index'])->name('modern-dashboard');
    Route::get('/modern-dashboard/chart-data', [ModernDashboardController::class, 'getChartData'])->name('modern-dashboard.chart-data');
    Route::get('/youtube-dashboard', [DashboardController::class, 'youtubeDashboard'])->name('youtube-dashboard');
    
    // Students Management
    Route::get('students/export-pdf', [StudentController::class, 'exportPdf'])->name('students.export-pdf');
    Route::resource('students', StudentController::class);
    Route::get('students/{student}/progress', [StudentController::class, 'progress'])->name('students.progress');
    Route::get('students-search', [StudentController::class, 'search'])->name('students.search');
    
    // Courses Management
    Route::resource('courses', CourseController::class);
    Route::get('courses-applications', [CourseController::class, 'applications'])->name('courses.applications');
    Route::patch('courses/applications/{application}/approve', [CourseController::class, 'approveApplication'])->name('courses.applications.approve');
    Route::patch('courses/applications/{application}/reject', [CourseController::class, 'rejectApplication'])->name('courses.applications.reject');
    
    // Teachers Management
    Route::get('teachers/salary-report', [TeacherController::class, 'salaryReport'])->name('teachers.salary-report');
    Route::get('teachers/salary-export', [TeacherController::class, 'salaryExport'])->name('teachers.salary-export');
    Route::resource('teachers', TeacherController::class);
    Route::get('teachers/{teacher}/workload', [TeacherController::class, 'workload'])->name('teachers.workload');
    Route::post('teachers/{teacher}/workload', [TeacherController::class, 'storeWorkload'])->name('teachers.store-workload');
    Route::patch('teachers/{teacher}/workload/{workload}/end', [TeacherController::class, 'endWorkload'])->name('teachers.end-workload');
    Route::get('teachers/{teacher}/salary', [TeacherController::class, 'salary'])->name('teachers.salary');
    Route::post('teachers/{teacher}/salary', [TeacherController::class, 'calculateSalary'])->name('teachers.calculate-salary');
    
    // Groups Management
    Route::resource('groups', GroupController::class);
    Route::post('groups/{group}/add-student', [GroupController::class, 'addStudent'])->name('groups.add-student');
    Route::delete('groups/{group}/students/{student}', [GroupController::class, 'removeStudent'])->name('groups.remove-student');
    
    // Lead Management
    Route::resource('leads', LeadController::class);
    Route::post('leads/{lead}/activities', [LeadController::class, 'addActivity'])->name('leads.add-activity');
    Route::patch('activities/{activity}/complete', [LeadController::class, 'completeActivity'])->name('leads.complete-activity');
    
    // Schedule Management
    Route::resource('schedules', ScheduleController::class)->except(['show', 'edit', 'update']);
    
    // Attendance Management
    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('students/{student}/attendance', [AttendanceController::class, 'studentAttendance'])->name('students.attendance');
    
    // Finance Management
    Route::prefix('finance')->name('finance.')->group(function () {
        Route::get('/', [FinanceController::class, 'index'])->name('index');
        Route::get('/payments', [FinanceController::class, 'payments'])->name('payments');
        Route::post('/payments', [FinanceController::class, 'storePayment'])->name('store-payment');
        Route::get('/payments/{payment}/edit', [FinanceController::class, 'editPayment'])->name('edit-payment');
        Route::put('/payments/{payment}', [FinanceController::class, 'updatePayment'])->name('update-payment');
        Route::delete('/payments/{payment}', [FinanceController::class, 'deletePayment'])->name('delete-payment');
        Route::get('/receipt/{payment}', [FinanceController::class, 'receipt'])->name('receipt');
        Route::get('/payments/{payment}/receipt', [FinanceController::class, 'receipt'])->name('payment-receipt');
        Route::get('/debtors', [FinanceController::class, 'debtors'])->name('debtors');
        Route::get('/transactions', [FinanceController::class, 'transactions'])->name('transactions');
        Route::post('/transactions', [FinanceController::class, 'storeTransaction'])->name('store-transaction');
        Route::get('/financial-reports', [FinanceController::class, 'financialReport'])->name('financial-reports');
        Route::get('/reports', [PaymentReportController::class, 'index'])->name('reports');
        Route::get('/detailed-report', [PaymentReportController::class, 'detailed'])->name('detailed-report');
        Route::get('/discounts', [FinanceController::class, 'discounts'])->name('discounts');
        Route::post('/discounts', [FinanceController::class, 'storeDiscount'])->name('store-discount');
    });
    
    // Expenses Management
    Route::resource('expenses', ExpenseController::class)->except(['show', 'edit', 'update']);
    
    // Certificates Management
    Route::resource('certificates', CertificateController::class)->except(['edit', 'update', 'destroy']);
    Route::get('certificates/{certificate}/download', [CertificateController::class, 'download'])->name('certificates.download');
    Route::get('certificates-templates', [CertificateController::class, 'templates'])->name('certificates.templates');
    Route::get('certificates-templates/create', [CertificateController::class, 'createTemplate'])->name('certificates.templates.create');
    Route::post('certificates-templates', [CertificateController::class, 'storeTemplate'])->name('certificates.templates.store');
    Route::get('certificates-templates/{template}/preview', [CertificateController::class, 'previewTemplate'])->name('certificates.templates.preview');
    
    // Gamification System
    Route::prefix('gamification')->name('gamification.')->group(function () {
        Route::get('/', [GamificationController::class, 'dashboard'])->name('dashboard');
        Route::post('/add-coins', [GamificationController::class, 'addCoins'])->name('add-coins');
        Route::get('/shop', [GamificationController::class, 'shop'])->name('shop');
        Route::get('/shop/create', [GamificationController::class, 'createShopItem'])->name('create-item');
        Route::post('/shop', [GamificationController::class, 'storeShopItem'])->name('store-item');
        Route::get('/items/{item}', [GamificationController::class, 'showShopItem'])->name('items.show');
        Route::put('/items/{item}', [GamificationController::class, 'updateShopItem'])->name('items.update');
        Route::post('/rewards', [GamificationController::class, 'storeReward'])->name('store-reward');
        Route::get('/purchases', [GamificationController::class, 'purchases'])->name('purchases');
        Route::patch('/purchases/{purchase}', [GamificationController::class, 'updatePurchaseStatus'])->name('update-purchase');
    });
    
    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/students', [ReportController::class, 'students'])->name('students');
        Route::get('/finance', [ReportController::class, 'finance'])->name('finance');
        Route::get('/performance', [ReportController::class, 'performance'])->name('performance');
        Route::get('/teachers', [ReportController::class, 'teacherAnalytics'])->name('teachers');
    });
    
    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    
    // Search
    Route::get('/search', [\App\Http\Controllers\SearchController::class, 'search'])->name('search');
    

    
    // Messages
    Route::resource('messages', MessageController::class)->only(['index', 'show', 'store']);
    Route::patch('/messages/{message}/read', [MessageController::class, 'markAsRead'])->name('messages.read');
    
    // Video Lessons
    Route::resource('video-lessons', VideoLessonController::class);
    
    // Live Streams
    Route::resource('live-streams', \App\Http\Controllers\LiveStreamController::class);
    Route::post('/live-streams/{liveStream}/start', [\App\Http\Controllers\LiveStreamController::class, 'startStream'])->name('live-streams.start');
    Route::post('/live-streams/{liveStream}/end', [\App\Http\Controllers\LiveStreamController::class, 'endStream'])->name('live-streams.end');
    Route::post('/live-streams/{liveStream}/viewers', [\App\Http\Controllers\LiveStreamController::class, 'updateViewers'])->name('live-streams.viewers');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/terminate-session', [ProfileController::class, 'terminateSession'])->name('profile.terminate-session');
    Route::post('/profile/terminate-all-sessions', [ProfileController::class, 'terminateAllSessions'])->name('profile.terminate-all-sessions');
    
    // Sliders Management
    Route::resource('sliders', \App\Http\Controllers\SliderController::class)->except(['show', 'create', 'edit']);
    
    // Files Management
    Route::get('/files', [FileController::class, 'index'])->name('files.index');
    Route::post('/files', [FileController::class, 'store'])->name('files.store');
    Route::delete('/files/{file}', [FileController::class, 'destroy'])->name('files.destroy');
    Route::get('/files/{file}/download', [FileController::class, 'download'])->name('files.download');
    
    // Branches Management
    Route::resource('branches', BranchController::class);
    Route::post('branches/switch', [BranchController::class, 'switchBranch'])->name('branches.switch');
    
    // Settings Management
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
    
    // Bulk Actions
    Route::post('bulk/export', [\App\Http\Controllers\Admin\BulkController::class, 'export'])->name('bulk.export');
    Route::delete('bulk/delete', [\App\Http\Controllers\Admin\BulkController::class, 'delete'])->name('bulk.delete');
    Route::post('files/upload', [FileController::class, 'upload'])->name('files.upload');
});

// Teacher Routes
Route::prefix('teacher')->name('teacher.')->middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [\App\Http\Controllers\Teacher\ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [\App\Http\Controllers\Teacher\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\Teacher\ProfileController::class, 'update'])->name('profile.update');
    
    // Groups
    Route::get('/groups', [\App\Http\Controllers\Teacher\GroupController::class, 'index'])->name('groups');
    Route::get('/groups/{group}', [\App\Http\Controllers\Teacher\GroupController::class, 'show'])->name('groups.show');
    
    // Other routes
    Route::get('/schedule', function() { return view('teacher.schedule'); })->name('schedule');
    Route::get('/materials', function() { return view('teacher.materials'); })->name('materials');
    Route::get('/assignments', [\App\Http\Controllers\Teacher\AssignmentController::class, 'index'])->name('assignments');
    Route::get('/grades', function() { return view('teacher.grades'); })->name('grades');
    Route::get('/attendance', function() { return view('teacher.attendance'); })->name('attendance');
    Route::get('/messages', function() { return view('teacher.messages'); })->name('messages');
    Route::get('/reports', function() { return view('teacher.reports'); })->name('reports');
});

// Student Routes
Route::prefix('student')->name('student.')->middleware(['auth', 'role:student'])->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [\App\Http\Controllers\Student\ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [\App\Http\Controllers\Student\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\Student\ProfileController::class, 'update'])->name('profile.update');
    
    // Courses
    Route::get('/courses', [\App\Http\Controllers\Student\CourseController::class, 'index'])->name('courses');
    Route::post('/courses/apply', [\App\Http\Controllers\Student\CourseController::class, 'apply'])->name('courses.apply');
    Route::get('/schedule', function() { return view('student.schedule'); })->name('schedule');
    Route::get('/materials', function() { return view('student.materials'); })->name('materials');
    Route::get('/assignments', function() { return view('student.assignments'); })->name('assignments');
    Route::get('/grades', function() { return view('student.grades'); })->name('grades');
    Route::get('/messages', function() { return view('student.messages'); })->name('messages');
    Route::get('/payments', [\App\Http\Controllers\Student\PaymentController::class, 'index'])->name('payments');
    Route::post('/payments', [\App\Http\Controllers\Student\PaymentController::class, 'store'])->name('payments.store');
    Route::get('/calendar', function() { return view('student.calendar'); })->name('calendar');
});

// Staff Routes (Cashier, Receptionist)
Route::prefix('staff')->name('staff.')->middleware(['auth', 'role:cashier,receptionist'])->group(function () {
    Route::get('/dashboard', function() {
        return view('staff.dashboard');
    })->name('dashboard');
});