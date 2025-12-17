<?php

use App\Http\Controllers\Api\AuthTelegramController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::post('/auth/telegram', [AuthTelegramController::class, 'login']);
Route::middleware(['auth:sanctum','admin'])->get('/admin/users', function () {
    return User::query()->orderByDesc('id')->paginate(50);
});
