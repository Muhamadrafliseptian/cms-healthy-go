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
            Route::get('/', [ProgramController::class, 'index'])->name('program.index');
            Route::post('store', [ProgramController::class, 'store'])->name('program.store');
            Route::put('put/{id}', [ProgramController::class, 'update'])->name('program.put');
            Route::delete('destroy/{id}', [ProgramController::class, 'destroy'])->name('program.destroy');
        });

        Route::prefix('certificate')->group(function () {
            Route::get('/', [CertificateController::class, 'index'])->name('certificate.index');
            Route::post('store', [CertificateController::class, 'store'])->name('certificate.store');
            Route::put('put/{id}', [CertificateController::class, 'update'])->name('certificate.put');
            Route::delete('destroy/{id}', [CertificateController::class, 'destroy'])->name('certificate.destroy');
        });

        Route::prefix('service')->group(function () {
            Route::get('/', [ServiceController::class, 'index'])->name('service.index');
            Route::post('store', [ServiceController::class, 'store'])->name('service.store');
            Route::put('put/{id}', [ServiceController::class, 'update'])->name('service.put');
            Route::delete('destroy/{id}', [ServiceController::class, 'destroy'])->name('service.destroy');
        });

        Route::prefix('testimoni')->group(function () {
            Route::get('/', [TestimoniController::class, 'index'])->name('testimoni.index');
            Route::post('store', [TestimoniController::class, 'store'])->name('testimoni.store');
            Route::put('put/{id}', [TestimoniController::class, 'update'])->name('testimoni.put');
            Route::delete('destroy/{id}', [TestimoniController::class, 'destroy'])->name('testimoni.destroy');
        });

        Route::prefix('partnership')->group(function () {
            Route::get('/', [PartnershipController::class, 'index'])->name('partnership.index');
            Route::post('store', [PartnershipController::class, 'store'])->name('partnership.store');
            Route::put('put/{id}', [PartnershipController::class, 'update'])->name('partnership.put');
            Route::delete('destroy/{id}', [PartnershipController::class, 'destroy'])->name('partnership.destroy');
        });
    });
});
