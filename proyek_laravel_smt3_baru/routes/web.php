<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;


Route::resource('employees',EmployeeController::class);
Route::resource('departments', DepartmentController::class);
Route::resource('attendance', AttendanceController::class);
