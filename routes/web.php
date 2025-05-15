<?php

use App\Http\Controllers\CarouselController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\OperationalStatisticController;
use App\Http\Controllers\PartnershipController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\TnCController;
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

    Route::prefix('product-service')->group(function () {
        Route::prefix('promo')->group(function () {
            Route::get('/', [PromoController::class, 'index'])->name('promo.index');
            Route::post('store', [PromoController::class, 'store'])->name('promo.store');
            Route::put('put/{id}', [PromoController::class, 'update'])->name('promo.put');
            Route::delete('destroy/{id}', [PromoController::class, 'destroy'])->name('promo.destroy');
        });
        Route::prefix('program')->group(function () {
            Route::get('/', [ProgramController::class, 'index'])->name('programProduct.index');
            Route::post('store', [ProgramController::class, 'store'])->name('programProduct.store');
            Route::put('put/{id}', [ProgramController::class, 'update'])->name('programProduct.put');
            Route::delete('destroy/{id}', [ProgramController::class, 'destroy'])->name('programProduct.destroy');
        });
        Route::prefix('meal')->group(function () {
            Route::get('/', [MealController::class, 'index'])->name('meal.index');
            Route::post('store', [MealController::class, 'store'])->name('meal.store');
            Route::put('put/{id}', [MealController::class, 'update'])->name('meal.put');
            Route::delete('destroy/{id}', [MealController::class, 'destroy'])->name('meal.destroy');
        });
    });

    Route::prefix('food')->group(function () {
        Route::prefix('carousel')->group(function () {
            Route::get('/', [CarouselController::class, 'index'])->name('carousel.index');
            Route::post('store', [CarouselController::class, 'store'])->name('carousel.store');
            Route::put('put/{id}', [CarouselController::class, 'update'])->name('carousel.put');
            Route::delete('destroy/{id}', [CarouselController::class, 'destroy'])->name('carousel.destroy');
        });
        Route::prefix('batch-menu')->group(function () {
            Route::get('/', [MenuController::class, 'index'])->name('batch-menu.index');
            Route::post('store', [MenuController::class, 'store'])->name('batch-menu.store');
            Route::put('put/{id}', [MenuController::class, 'update'])->name('batch-menu.put');
            Route::delete('destroy/{id}', [MenuController::class, 'destroy'])->name('batch-menu.destroy');
        });
    });

    Route::prefix('etc')->group(function () {
        Route::prefix('sosmed')->group(function () {
            Route::get('/', [SocialMediaController::class, 'index'])->name('sosmed.index');
            Route::post('store', [SocialMediaController::class, 'store'])->name('sosmed.store');
            Route::put('put/{id}', [SocialMediaController::class, 'update'])->name('sosmed.put');
            Route::delete('destroy/{id}', [SocialMediaController::class, 'destroy'])->name('sosmed.destroy');
        });
        Route::prefix('tnc')->group(function () {
            Route::get('/', [TnCController::class, 'index'])->name('tnc.index');
            Route::post('store', [TnCController::class, 'store'])->name('tnc.store');
            Route::put('put/{id}', [TnCController::class, 'update'])->name('tnc.put');
            Route::delete('destroy/{id}', [TnCController::class, 'destroy'])->name('tnc.destroy');
        });
        Route::prefix('contact')->group(function () {
            Route::get('/', [ContactController::class, 'index'])->name('contact.index');
            Route::post('store', [ContactController::class, 'store'])->name('contact.store');
            Route::put('put/{id}', [ContactController::class, 'update'])->name('contact.put');
            Route::delete('destroy/{id}', [ContactController::class, 'destroy'])->name('contact.destroy');
        });
        Route::prefix(prefix: 'faq')->group(function () {
            Route::get('/', [FaqController::class, 'index'])->name('faq.index');
            Route::post('store', [FaqController::class, 'store'])->name('faq.store');
            Route::put('put/{id}', [FaqController::class, 'update'])->name('faq.put');
            Route::delete('destroy/{id}', [FaqController::class, 'destroy'])->name('faq.destroy');
        });
    });
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
