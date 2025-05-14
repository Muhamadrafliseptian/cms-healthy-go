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
Route::apiResource('carousels', CarouselController::class);
Route::apiResource('faqs', FaqController::class);
Route::apiResource('meals', MealController::class);
Route::apiResource('batch_menus', MenuController::class);
Route::apiResource('partnerships', PartnershipController::class);
Route::apiResource('programs', ProgramController::class);
Route::apiResource('promos', PromoController::class);
Route::apiResource('testimonis', TestimoniController::class);
Route::apiResource('tncs', TestimoniController::class);
Route::apiResource('sosmeds', SocialMediaController::class);
Route::apiResource('contacts', ContactController::class);