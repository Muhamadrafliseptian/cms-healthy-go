<?php

use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PartnershipController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TestimoniController;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('home')->group(function () {
        Route::prefix('program')->group(function () {
            Route::get('/test', [ProgramController::class, 'index'])->name('program.index');
        });

        Route::prefix('certificate')->group(function () {
            Route::get('/', [CertificateController::class, 'index'])->name('certificate.index');
        });

        Route::prefix('testimoni')->group(function () {
            Route::get('/', [TestimoniController::class, 'index'])->name('testimoni.index');
        });

        Route::prefix('partnership')->group(function () {
            Route::get('/', [PartnershipController::class, 'index'])->name('partnership.index');
        });

        Route::prefix('service')->group(function () {
            Route::get('/', [ServiceController::class, 'index'])->name('service.index');
            Route::post('store', [ServiceController::class, 'store'])->name('service.store');
        });
    });
});
