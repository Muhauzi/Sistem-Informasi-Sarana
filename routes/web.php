<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\DivisionsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/sarana-scan/{id}', [ItemController::class, 'apiShow'])->name('sarana-scan.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth', 'role:admin,pengelola')->prefix('kategori-sarana')->name('kategori-sarana.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/create', [CategoryController::class, 'create'])->name('create');
    Route::post('/store', [CategoryController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
    Route::put('/{id}/update', [CategoryController::class, 'update'])->name('update');
    Route::delete('/{id}/destroy', [CategoryController::class, 'destroy'])->name('destroy');
});

Route::middleware('auth')->prefix('sarana')->name('sarana.')->group(function () {
    Route::get('/', [ItemController::class, 'index'])->name('index');
    Route::get('/create', [ItemController::class, 'create'])->name('create');
    Route::post('/store', [ItemController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [ItemController::class, 'edit'])->name('edit');
    Route::put('/{id}/update', [ItemController::class, 'update'])->name('update');
    Route::delete('/{id}/destroy', [ItemController::class, 'destroy'])->name('destroy');
    Route::get('/{id}', [ItemController::class, 'show'])->name('show');
    Route::post('/cetak/{id}', [ItemController::class, 'qrGenerate'])->name('generateQrCode');
});

Route::middleware('auth', 'role:admin,pengelola')->prefix('divisi')->name('divisi.')->group(function () {
    Route::get('/', [DivisionsController::class, 'index'])->name('index');
    Route::get('/create', [DivisionsController::class, 'create'])->name('create');
    Route::post('/store', [DivisionsController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [DivisionsController::class, 'edit'])->name('edit');
    Route::put('/{id}/update', [DivisionsController::class, 'update'])->name('update');
    Route::delete('/{id}/destroy', [DivisionsController::class, 'destroy'])->name('destroy');
    Route::get('/{id}', [DivisionsController::class, 'show'])->name('show');
});

Route::middleware('auth', 'role:admin,pengelola')->prefix('distributions')->name('distributions.')->group(function () {
    Route::get('/', [DistributionController::class, 'index'])->name('index');
    Route::get('/create', [DistributionController::class, 'create'])->name('create');
    Route::get('/get-items/{id}', [DistributionController::class, 'createGetItems'])->name('get-items');
    Route::post('/store', [DistributionController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [DistributionController::class, 'edit'])->name('edit');
    Route::put('/{id}/update', [DistributionController::class, 'update'])->name('update');
    Route::delete('/{id}/destroy', [DistributionController::class, 'destroy'])->name('destroy');
    Route::get('/{id}', [DistributionController::class, 'show'])->name('show');
});

Route::middleware(['auth', 'role:admin'])->prefix('users')->name('users.')->group(function () {
    Route::get('/', [\App\Http\Controllers\UsersController::class, 'index'])->name('index');
    Route::get('/create', [\App\Http\Controllers\UsersController::class, 'create'])->name('create');
    Route::post('/store', [\App\Http\Controllers\UsersController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [\App\Http\Controllers\UsersController::class, 'edit'])->name('edit');
    Route::put('/{id}/update', [\App\Http\Controllers\UsersController::class, 'update'])->name('update');
    Route::delete('/{id}/destroy', [\App\Http\Controllers\UsersController::class, 'destroy'])->name('destroy');
    Route::get('/{id}', [\App\Http\Controllers\UsersController::class, 'show'])->name('show');
});


require __DIR__.'/auth.php';
