<?php

use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\FirebaseController; 
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\PostController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\NotificationController;

Route::resource('posts', PostController::class)
     ->except(['show']);
Route::get('/dashboard', [AuthController::class, 'dashboard'])
     ->name('dashboard');
// Edit
Route::get('/posts/{id}/edit', [PostController::class, 'edit'])
     ->name('posts.edit');

// Update
Route::put('/posts/{id}', [PostController::class, 'update'])
     ->name('posts.update');

// Delete
Route::delete('/posts/{id}', [PostController::class, 'destroy'])
     ->name('posts.destroy');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index'); 
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create'); 
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');  

Route::get('/create-user', [FirebaseController::class, 'create']);  
Route::get('/login', [AuthController::class, 'loginForm'])->name('login.form');  
Route::post('/login', [AuthController::class, 'login'])->name('login');  
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');  
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');  
Route::get('/register', [AuthController::class, 'registerForm'])->name('register.form');  
Route::post('/register', [AuthController::class, 'register'])->name('register');  
Route::get('/riwayat', [RiwayatController::class, 'index']);

Route::get('/', [AuthController::class, 'login']);



use App\Http\Controllers\UserRoleController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/users', [UserRoleController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/{uid}/edit', [UserRoleController::class, 'edit'])->name('admin.users.edit');
    Route::post('/admin/users/{uid}/update', [UserRoleController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{uid}/delete', [UserRoleController::class, 'destroy'])->name('admin.users.delete');
});

Route::post('/notification-token', [TokenController::class, 'updateFCMToken']); // harus POST
Route::post('/send-notification', [NotificationController::class, 'sendNotification']); // harus POST
