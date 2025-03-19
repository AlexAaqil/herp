<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Users\ProfileController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Users\TeacherController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Users\GuardianController;
use App\Http\Controllers\Users\StudentController;
use App\Http\Controllers\Classrooms\ClassroomCategoryController;
use App\Http\Controllers\Classrooms\ClassroomController;
use App\Http\Controllers\DormController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\TeacherSubjectClassroomController;
use App\Http\Controllers\GuardianStudentController;
use App\Http\Controllers\DisciplinaryController;
use App\Http\Controllers\LeaveoutController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\TextbookController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamRecordController;
use App\Http\Controllers\Payments\PaymentController;
use App\Http\Controllers\Payments\PaymentRecordController;
use App\Http\Controllers\Payments\PaymentReceiptController;
use App\Http\Controllers\Payments\ExpenseCategoryController;
use App\Http\Controllers\Payments\ExpenseRecipientController;
use App\Http\Controllers\Payments\ExpenseController;
use App\Http\Controllers\Inventory\InventoryCategoryController;
use App\Http\Controllers\Inventory\InventoryItemController;
use App\Http\Controllers\Inventory\InventoryRecordController;
use App\Http\Controllers\SettingController;

Route::view('/', 'index')->name('home-page');
Route::view('/about', 'about')->name('about-page');
Route::view('/services', 'services')->name('services-page');
Route::view('/contact', 'contact')->name('contact-page');
Route::post('/contact', [MessageController::class, 'store'])->name('messages.store');

Route::middleware(['auth', 'verified', 'active'])->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('disciplinaries', DisciplinaryController::class)->except('show');

    Route::resource('leaveouts', LeaveoutController::class)->except('show');
    Route::get('/leaveouts/{leaveout}/print', [LeaveoutController::class, 'print'])->name('leaveouts.print');

    Route::resource('leaves', LeaveController::class)->parameters(['leaves' => 'leave'])->except('show');

    Route::resource('textbooks', TextbookController::class)->except('show');

    Route::resource('assignments', AssignmentController::class)->except('show');
    Route::get('assignments/{assignment}/download', [AssignmentController::class, 'download'])->name('assignments.download');

    Route::resource('exams', ExamController::class)->except('show');
    Route::resource('exam-records', ExamRecordController::class)->except('show');

    Route::resource('payments', PaymentController::class)->except('show');
    Route::resource('payment-records', PaymentRecordController::class)->only(['index', 'store', 'destroy']);
    Route::get('/payment-records/create/{student_id}', [PaymentRecordController::class, 'create'])->name('payment-records.create');
    Route::get('/payment-receipts/generate-receipt/{student_id}', [PaymentReceiptController::class, 'generateReceipt'])->name('payment-records.generate_receipt');
    Route::post('/payment-receipts/print-receipt/{student_id}', [PaymentReceiptController::class, 'printReceipt'])->name('payment-records.print_receipt');
    Route::get('/payment-receipts/generate-gatepass/{student_id}', [PaymentReceiptController::class, 'generateGatepass'])->name('payment-records.generate_gatepass');
    Route::post('/payment-receipts/print-gatepass/{student_id}', [PaymentReceiptController::class, 'printGatepass'])->name('payment-records.print_gatepass');

    Route::resource('expense-categories', ExpenseCategoryController::class)->except('create', 'show');
    Route::resource('expense-recipients', ExpenseRecipientController::class)->except('show');
    Route::resource('expenses', ExpenseController::class)->except('show');

    Route::resource('inventory-categories', InventoryCategoryController::class)->except('create', 'show');
    Route::resource('inventory-items', InventoryItemController::class)->except('index', 'create', 'show');
    Route::resource('inventory-records', InventoryRecordController::class)->except('show');

    Route::middleware(['admin'])->group(function() {
        Route::resource('users', UserController::class)->except('show');
        Route::resource('teachers', TeacherController::class)->only('index', 'edit', 'update');
        Route::resource('teacher-subjects',TeacherSubjectClassroomController::class)->only('store', 'edit', 'update', 'destroy');

        Route::resource('guardians', GuardianController::class)->except('show');
        Route::resource('students', StudentController::class)->except('show');
        Route::resource('student-guardians', GuardianStudentController::class)->only('store', 'edit', 'update', 'destroy');

        Route::resource('classroom-categories', ClassroomCategoryController::class)->only('store', 'edit', 'update', 'destroy');
        Route::resource('classrooms', ClassroomController::class)->except('show');

        Route::resource('dorms', DormController::class)->except('show');

        Route::resource('subjects', SubjectController::class)->except('show');

        Route::resource('grades', GradeController::class)->except('show');

        Route::resource('messages', MessageController::class)->only('index', 'edit', 'destroy');

        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::get('/settings/edit', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('/settings/update', [SettingController::class, 'update'])->name('settings.update');
        Route::delete('/settings/delete', [SettingController::class, 'destroy'])->name('settings.destroy');
    });
});

require __DIR__.'/auth.php';
