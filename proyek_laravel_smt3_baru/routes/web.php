<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PositionController;
use Illuminate\Support\Facades\Route;

// Redirect root ke employees
Route::get('/', function () {
    return redirect()->route('employees.index');
});

// Employee Routes
Route::resource('employees', EmployeeController::class);

// Export, Import, Print Routes
Route::post('/employees/export', [EmployeeController::class, 'export'])->name('employees.export');
Route::post('/employees/import', [EmployeeController::class, 'import'])->name('employees.import');
Route::get('/employees/template/download', [EmployeeController::class, 'downloadTemplate'])->name('employees.template');
Route::post('/employees/print', [EmployeeController::class, 'printReport'])->name('employees.print');

// Department Routes
Route::resource('departments', DepartmentController::class);

// Payroll Routes
Route::resource('payroll', PayrollController::class);

// Leave Management Routes
Route::resource('leave', LeaveController::class);
Route::post('/leave/{id}/approve', [LeaveController::class, 'approve'])->name('leave.approve');
Route::post('/leave/{id}/reject', [LeaveController::class, 'reject'])->name('leave.reject');

// Attendance Routes
Route::resource('attendance', AttendanceController::class);

// Position Routes
Route::resource('positions', PositionController::class);
