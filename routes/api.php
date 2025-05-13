<?php

use App\Http\Controllers\CarouselController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PartnershipController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\TestimoniController;
use Illuminate\Support\Facades\Route;

Route::apiResource('services', ServiceController::class);
Route::apiResource('carousel', CarouselController::class);
Route::apiResource('faq', FaqController::class);
Route::apiResource('meal', MealController::class);
Route::apiResource('batch_menu', MenuController::class);
Route::apiResource('partnership', PartnershipController::class);
Route::apiResource('program', ProgramController::class);
Route::apiResource('promo', PromoController::class);
Route::apiResource('services', ServiceController::class);
Route::apiResource('testimoni', TestimoniController::class);
Route::apiResource('tnc', TestimoniController::class);
Route::apiResource('sosmed', SocialMediaController::class);
Route::apiResource('contact', ContactController::class);