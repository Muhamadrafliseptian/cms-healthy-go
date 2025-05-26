<?php

use App\Http\Controllers\AboutSectionController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\CarouselController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FoodSectionController;
use App\Http\Controllers\HomeSectionController;
use App\Http\Controllers\IklanController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\OperationalStatisticController;
use App\Http\Controllers\PartnershipController;
use App\Http\Controllers\PartnershipSectionController;
use App\Http\Controllers\ProductSectionController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

Route::prefix('lp')->group(function () {
    Route::prefix('home')->group(function () {
        Route::prefix('section')->group(function () {
            Route::post('banner', [HomeSectionController::class, 'index']);
            Route::post('video', [VideoController::class, 'index']);
            Route::post('layanan', [ServiceController::class, 'index']);
        });
    });
    Route::prefix('about')->group(function () {
        Route::prefix('section')->group(function () {
            Route::post('banner', [AboutSectionController::class, 'index']);
            Route::post('description', [AboutSectionController::class, 'indexContentDescription']);
            Route::post('milestone', [MilestoneController::class, 'index']);
        });
    });
    Route::prefix('partnership')->group(function () {
        Route::prefix('section')->group(function () {
            Route::post('main', [PartnershipController::class, 'index']);
            Route::post('banner', [PartnershipSectionController::class, 'indexBanner']);
            Route::post('tag', [PartnershipSectionController::class, 'indexContentTag']);
            Route::post('collaborate', [PartnershipSectionController::class, 'indexContentCollaborate']);
            Route::post('hero', [PartnershipSectionController::class, 'indexContentHero']);
        });
    });
    Route::prefix('food')->group(function () {
        Route::prefix('section')->group(function () {
            Route::post('banner', [FoodSectionController::class, 'indexBanner']);
            Route::post('carousel', [CarouselController::class, 'index']);
        });
    });
    Route::prefix('product-service')->group(function () {
        Route::prefix('section')->group(function () {
            Route::post('banner', [ProductSectionController::class, 'indexBanner']);
            Route::post('tag', [ProductSectionController::class, 'indexContentTag']);
            Route::post('collaborate', [ProductSectionController::class, 'indexContentSolution']);
            Route::post('promo', [PromoController::class, 'index']);
        });
    });
    Route::prefix('iklan')->group(function () {
        Route::prefix('section')->group(function () {
            Route::post('banner', [IklanController::class, 'indexBanner']);
            Route::post('achievement', [IklanController::class, 'indexAchievement']);
            Route::post('benefit', [IklanController::class, 'indexBenefit']);
            Route::post('galeri', [IklanController::class, 'indexGaleri']);
            Route::post('pains', [IklanController::class, 'indexPains']);
            Route::post('goals', [IklanController::class, 'indexGoals']);
            Route::post('promo', [IklanController::class, 'indexPromo']);
        });
    });
    Route::prefix('etc')->group(function () {
        Route::prefix('section')->group(function () {
            Route::post('faq', [FaqController::class, 'index']);
        });
    });
    Route::prefix('master')->group(function () {
        Route::prefix('konten')->group(function () {
            Route::post('certificate', [CertificateController::class, 'index']);
            Route::post('program', [ProgramController::class, 'index']);
            Route::post('img-partnership', [PartnershipController::class, 'indexHomePartnership']);
            Route::post('testimoni', [TestimoniController::class, 'index']);
            Route::post('meals', [MealController::class, 'index']);
            Route::post('menu', [MenuController::class, 'index']);
            Route::post('statistic', [OperationalStatisticController::class, 'index']);
            Route::post('batch', [BatchController::class, 'index']);
        });
    });
});

