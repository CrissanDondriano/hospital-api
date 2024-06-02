<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DoctorController;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/user', [UserController::class, 'index']);
Route::post('/newUser', [UserController::class, 'store']);
Route::get('/getUser/{id}', [UserController::class, 'show']);
Route::put('/update/User/{id}', [UserController::class, 'update']);
Route::delete('/deleteUser/{id}', [UserController::class, 'destroy']);
Route::get('/searchUser/{title}', [UserController::class, 'search']);

// DOCTOR CONTROLLER API ENDPOINTS
Route::get('/doctors', [DoctorController::class, 'index']);
Route::post('/doctors', [DoctorController::class, 'store']);
Route::get('/doctors/{id}', [DoctorController::class, 'show']);
Route::put('/doctors/{id}', [DoctorController::class, 'update']);
Route::delete('/doctors/{id}', [DoctorController::class, 'destroy']);
