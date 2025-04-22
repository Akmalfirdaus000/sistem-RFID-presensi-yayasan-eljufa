<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\RFIDController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AttendanceController;

Route::post('/attendance', [AttendanceController::class, 'store']);

// Route::post('/users', [UserController::class, 'getUserByRfid']);

// Route::post('/register', [UserController::class, 'store']);





