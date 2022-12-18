<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

// Routes for user portal
Route::get('/', [UserController::class, 'index'])->name('index');
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/createaccount', [UserController::class, 'createaccount'])->name('createaccount');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/userportal', [UserController::class, 'userportal'])->name('userportal');
Route::post('/markattendance', [UserController::class, 'markattendance'])->name('markattendance');
Route::post('/leavereq', [UserController::class, 'leavereq'])->name('leavereq');
Route::post('/updatepicture', [UserController::class, 'updatepicture'])->name('updatepicture');

// Routes for admin portal
Route::get('/adminportal', [AdminController::class, 'adminportal'])->name('adminportal');
Route::get('/adminview', [AdminController::class, 'adminview'])->name('adminview');
Route::post('/adminlogin', [AdminController::class, 'adminlogin'])->name('adminlogin');
Route::get('/view_students_record', [AdminController::class, 'view_students_record'])->name('view_students_record');
Route::post('/add_attendance', [AdminController::class, 'add_attendance'])->name('add_attendance');
Route::get('/admin_manage_attendance', [AdminController::class, 'admin_manage_attendance'])->name('admin_manage_attendance');
Route::post('/edit_attendance', [AdminController::class, 'edit_attendance'])->name('edit_attendance');
Route::delete('/destroy', [AdminController::class, 'destroy'])->name('destroy');
Route::get('/leave_requests', [AdminController::class, 'leave_requests'])->name('leave_requests');
Route::post('/approved', [AdminController::class, 'approved'])->name('approved');
Route::post('/disapproved', [AdminController::class, 'disapproved'])->name('disapproved');
Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
Route::get('/grades', [AdminController::class, 'grades'])->name('grades');
