<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

Route::middleware('api')->get('/sarana-scan/{id}', [ItemController::class, 'apiShow'])->name('api.sarana-scan.show');