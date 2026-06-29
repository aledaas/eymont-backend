<?php

use Illuminate\Support\Facades\Route;

Route::prefix('content')
    ->name('content.')
    ->group(function () {
        Route::get('/health', function () {
            return response()->json([
                'module' => 'content',
                'status' => 'ok',
            ]);
        })->name('health');
    });
