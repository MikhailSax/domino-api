<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthTelegramController;
use App\Models\User;


Route::post('/auth/telegram', [AuthTelegramController::class, 'login']);
Route::middleware(['auth:sanctum', 'admin'])->get('/admin/users', function () {
    return User::query()->orderByDesc('id')->paginate(50);
});
Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum', 'admin'])->get('/admin/users', function () {
    return User::query()
        ->select('id','telegram_id','telegram_username','first_name','last_name','name','is_admin','created_at')
        ->orderByDesc('id')
        ->paginate(50);
});

Route::get('/catalog/categories', [CategoryController::class, 'index']);
Route::get('/catalog/products', [ProductController::class, 'index']);
Route::get('/catalog/products/{slug}', [ProductController::class, 'show']);

Route::middleware('auth:sanctum')->post('/orders', [OrderController::class, 'store']);
Route::middleware('auth:sanctum')->get('/orders', [OrderController::class, 'index']);
Route::middleware('auth:sanctum')->get('/orders/{order}', [OrderController::class, 'show']);
