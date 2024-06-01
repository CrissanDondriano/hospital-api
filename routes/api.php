<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/products', [ProductController::class, 'index']);
Route::post('/newProducts', [ProductController::class, 'store']);
Route::get('/getProducts/{id}', [ProductController::class, 'show']);
Route::put('/update/Products/{id}', [ProductController::class, 'update']);
Route::delete('/deleteProducts/{id}', [ProductController::class, 'destroy']);
Route::get('/searchProducts/{title}', [ProductController::class, 'search']);


Route::get('/user', [UserController::class, 'index']);
Route::post('/newUser', [UserController::class, 'store']);
Route::get('/getUser/{id}', [UserController::class, 'show']);
Route::put('/update/User/{id}', [UserController::class, 'update']);
Route::delete('/deleteUser/{id}', [UserController::class, 'destroy']);
Route::get('/searchUser/{title}', [UserController::class, 'search']);