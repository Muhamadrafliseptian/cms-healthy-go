<?php

use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\OperationalStatisticController;
use App\Http\Controllers\PartnershipController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('home')->group(function () {
        Route::prefix('partnership-home')->group(function () {
            Route::get('/', [PartnershipController::class, 'indexHomePartnership'])->name('partnershipHome.index');
            Route::post('store', [PartnershipController::class, 'storeHomePartnership'])->name('partnershipHome.store');
            Route::put('put/{id}', [PartnershipController::class, 'updateHomePartnership'])->name('partnershipHome.put');
            Route::delete('destroy/{id}', [PartnershipController::class, 'destroyHomePartnership'])->name('partnershipHome.destroy');
        });
        
        Route::prefix('program')->group(function () {
            Route::get('/', [ProgramController::class, 'index'])->name('program.index');
            Route::post('store', [ProgramController::class, 'store'])->name('program.store');
            Route::put('put/{id}', [ProgramController::class, 'update'])->name('program.put');
            Route::delete('destroy/{id}', [ProgramController::class, 'destroy'])->name('program.destroy');
        });

        Route::prefix('statistic')->group(function () {
            Route::get('/', [OperationalStatisticController::class, 'index'])->name('statistic.index');
            Route::post('store', [OperationalStatisticController::class, 'store'])->name('statistic.store');
            Route::put('put/{id}', [OperationalStatisticController::class, 'update'])->name('statistic.put');
            Route::delete('destroy/{id}', [OperationalStatisticController::class, 'destroy'])->name('statistic.destroy');
        });

        Route::prefix('video')->group(function () {
            Route::get('/', [VideoController::class, 'index'])->name('video.index');
            Route::post('store', [VideoController::class, 'store'])->name('video.store');
            Route::put('put/{id}', [VideoController::class, 'update'])->name('video.put');
            Route::delete('destroy/{id}', [VideoController::class, 'destroy'])->name('video.destroy');
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
    });

    Route::prefix('about-us')->group(function () {
        Route::prefix('partnership')->group(function () {
            Route::get('/', [PartnershipController::class, 'indexHomePartnership'])->name('partnershipAbout.index');
            Route::post('store', [PartnershipController::class, 'storeHomePartnership'])->name('partnershipAbout.store');
            Route::put('put/{id}', [PartnershipController::class, 'updateHomePartnership'])->name('partnershipAbout.put');
            Route::delete('destroy/{id}', [PartnershipController::class, 'destroyHomePartnership'])->name('partnershipAbout.destroy');
        });
        Route::prefix('milestone')->group(function () {
            Route::get('/', [MilestoneController::class, 'index'])->name('milestone.index');
            Route::post('store', [MilestoneController::class, 'store'])->name('milestone.store');
            Route::put('put/{id}', [MilestoneController::class, 'update'])->name('milestone.put');
            Route::delete('destroy/{id}', [MilestoneController::class, 'destroy'])->name('milestone.destroy');
        });
    });
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
