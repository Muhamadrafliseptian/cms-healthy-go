<?php

use App\Http\Controllers\AboutSectionController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\CarouselController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FoodSectionController;
use App\Http\Controllers\HomeSectionController;
use App\Http\Controllers\IklanController;
use App\Http\Controllers\MasterSectionCategoryController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MetaTagController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\OperationalStatisticController;
use App\Http\Controllers\PartnershipController;
use App\Http\Controllers\PartnershipSectionController;
use App\Http\Controllers\ProductSectionController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\SectionContentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\TnCController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('home')->group(function () {
        Route::prefix('banner')->group(function () {
            Route::get('/', [HomeSectionController::class, 'index'])->name('section.home.index');
            Route::post('store', [HomeSectionController::class, 'storeSectionBanner'])->name('section.home.store');
            Route::put('put/{id}', [HomeSectionController::class, 'updateSectionBanner'])->name('section.home.put');
        });
        Route::prefix('description')->group(function () {
            Route::get('/', [HomeSectionController::class, 'index'])->name('section.description.index');
            Route::post('store', [HomeSectionController::class, 'storeSectionDescription'])->name('section.description.store');
            Route::put('put/{id}', [HomeSectionController::class, 'updateSectionDescription'])->name('section.description.put');
        });
        Route::prefix('video')->group(function () {
            Route::get('/', [VideoController::class, 'index'])->name('video.index');
            Route::post('store', [VideoController::class, 'store'])->name('video.store');
            Route::put('put/{id}', [VideoController::class, 'update'])->name('video.put');
            Route::delete('destroy/{id}', [VideoController::class, 'destroy'])->name('video.destroy');
        });
        Route::prefix('service')->group(function () {
            Route::get('/', [ServiceController::class, 'index'])->name('service.index');
            Route::post('store', [ServiceController::class, 'store'])->name('service.store');
            Route::post('section/store', [ServiceController::class, 'storeSectionService'])->name('section.service.store');
            Route::put('section/put/{id}', [ServiceController::class, 'updateSectionService'])->name('section.service.put');
            Route::put('put/{id}', [ServiceController::class, 'update'])->name('service.put');
            Route::delete('destroy/{id}', [ServiceController::class, 'destroy'])->name('service.destroy');
        });
    });

    Route::prefix('about-us')->group(function () {
        Route::prefix('milestone')->group(function () {
            Route::get('/', [MilestoneController::class, 'index'])->name('milestone.index');
            Route::post('store', [MilestoneController::class, 'store'])->name('milestone.store');
            Route::put('put/{id}', [MilestoneController::class, 'update'])->name('milestone.put');
            Route::post('section/store', [MilestoneController::class, 'storeSection'])->name('section.milestone.store');
            Route::put('section/put/{id}', [MilestoneController::class, 'updateSection'])->name('section.milestone.put');
            Route::delete('destroy/{id}', [MilestoneController::class, 'destroy'])->name('milestone.destroy');
        });
        Route::prefix('banner')->group(function () {
            Route::get('/', [AboutSectionController::class, 'index'])->name('section.about.index');
            Route::post('store', [AboutSectionController::class, 'storeSectionBanner'])->name('section.about.store');
            Route::put('put/{id}', [AboutSectionController::class, 'updateSectionBanner'])->name('section.about.put');
        });
        Route::prefix('description')->group(function () {
            Route::get('/', [AboutSectionController::class, 'indexContentDescription'])->name('section.about.description.index');
            Route::post('store', [AboutSectionController::class, 'storeSectionDescription'])->name('section.about.description.store');
            Route::put('put/{id}', [AboutSectionController::class, 'updateSectionDescription'])->name('section.about.description.put');
        });
    });

    Route::prefix('product-service')->group(function () {
        Route::prefix('promo')->group(function () {
            Route::get('/', [PromoController::class, 'index'])->name('promo.index');
            Route::post('store', [PromoController::class, 'store'])->name('promo.store');
            Route::put('put/{id}', [PromoController::class, 'update'])->name('promo.put');
            Route::post('section/store', [PromoController::class, 'storeContentPromo'])->name('section.promo.store');
            Route::put('section/put/{id}', [PromoController::class, 'updateContentPromo'])->name('section.promo.put');
            Route::delete('destroy/{id}', [PromoController::class, 'destroy'])->name('promo.destroy');
        });
        Route::prefix('banner')->group(function () {
            Route::get('/', [ProductSectionController::class, 'indexBanner'])->name('section.product.banner.index');
            Route::post('store', [ProductSectionController::class, 'storeSectionBanner'])->name('section.product.banner.store');
            Route::put('put/{id}', [ProductSectionController::class, 'updateSectionBanner'])->name('section.product.banner.put');
        });
        Route::prefix('tag')->group(function () {
            Route::get('/', [ProductSectionController::class, 'indexContentTag'])->name('section.product.tag.index');
            Route::post('store', [ProductSectionController::class, 'storeSectionContentTag'])->name('section.product.tag.store');
            Route::put('put/{id}', [ProductSectionController::class, 'updateSectionContentTag'])->name('section.product.tag.put');
        });
        Route::prefix('solution')->group(function () {
            Route::get('/', [ProductSectionController::class, 'indexContentSolution'])->name('section.product.solution.index');
            Route::post('store', [ProductSectionController::class, 'storeSectionContentSolution'])->name('section.product.solution.store');
            Route::put('put/{id}', [ProductSectionController::class, 'updateSectionContentSolution'])->name('section.product.solution.put');
        });
    });

    Route::prefix('food')->group(function () {
        Route::prefix('banner')->group(function () {
            Route::get('/', [FoodSectionController::class, 'indexBanner'])->name('section.food.banner.index');
            Route::post('store', [FoodSectionController::class, 'storeSectionBanner'])->name('section.food.banner.store');
            Route::put('put/{id}', [FoodSectionController::class, 'updateSectionBanner'])->name('section.food.banner.put');
        });
        Route::prefix('carousel')->group(function () {
            Route::get('/', [CarouselController::class, 'index'])->name('carousel.index');
            Route::post('store', [CarouselController::class, 'store'])->name('carousel.store');
            Route::put('put/{id}', [CarouselController::class, 'update'])->name('carousel.put');
            Route::post('section/store', [CarouselController::class, 'storeSectionCarousel'])->name('section.carousel.store');
            Route::put('section/put/{id}', [CarouselController::class, 'updateSectionCarousel'])->name('section.carousel.put');
            Route::delete('destroy/{id}', [CarouselController::class, 'destroy'])->name('carousel.destroy');
        });
    });

    Route::prefix('iklan')->group(function () {
        Route::prefix('achievement')->group(function () {
            Route::get('/', [IklanController::class, 'indexAchievement'])->name('achievement.index');
            Route::post('store', [IklanController::class, 'storeAchievement'])->name('achievement.store');
            Route::put('put/{id}', [IklanController::class, 'updateAchievement'])->name('achievement.put');
        });
        Route::prefix('banner')->group(function () {
            Route::get('/', [IklanController::class, 'indexBanner'])->name('banner.index');
            Route::post('store', [IklanController::class, 'storeBanner'])->name('banner.store');
            Route::put('put/{id}', [IklanController::class, 'updateBanner'])->name('banner.put');
        });
        Route::prefix('benefit')->group(function () {
            Route::get('/', [IklanController::class, 'indexBenefit'])->name('benefits.index');
            Route::post('store', [IklanController::class, 'storeBenefit'])->name('benefits.store');
            Route::put('put/{id}', [IklanController::class, 'updateBenefit'])->name('benefits.put');
            Route::delete('destroy/{id}', [IklanController::class, 'destroyBenefit'])->name('benefits.destroy');
        });
        Route::prefix('galeri')->group(function () {
            Route::get('/', [IklanController::class, 'indexGaleri'])->name('galeri.index');
            Route::post('store', [IklanController::class, 'storeGaleri'])->name('galeri.store');
            Route::put('put/{id}', [IklanController::class, 'updateGaleri'])->name('galeri.put');
            Route::delete('destroy/{id}', [IklanController::class, 'destroyGaleri'])->name('galeri.destroy');
        });
        Route::prefix('goals')->group(function () {
            Route::get('/', [IklanController::class, 'indexGoals'])->name('goals.index');
            Route::post('store', [IklanController::class, 'storeGoals'])->name('goals.store');
            Route::put('put/{id}', [IklanController::class, 'updateGoals'])->name('goals.put');
        });
        Route::prefix('pains')->group(function () {
            Route::get('/', [IklanController::class, 'indexPains'])->name('pains.index');
            Route::post('store', [IklanController::class, 'storePains'])->name('pains.store');
            Route::put('put/{id}', [IklanController::class, 'updatePains'])->name('pains.put');
            Route::delete('destroy/{id}', [IklanController::class, 'destroyPains'])->name('pains.destroy');
        });
        Route::prefix('promo')->group(function () {
            Route::get('/', [IklanController::class, 'indexPromo'])->name('promoIklan.index');
            Route::post('store', [IklanController::class, 'storePromo'])->name('promoIklan.store');
            Route::put('put/{id}', [IklanController::class, 'updatePromo'])->name('promoIklan.put');
        });
    });

    Route::prefix('meta')->group(function(){
        Route::get('/', [MetaTagController::class, 'index'])->name('meta.index');
        Route::post('store', [MetaTagController::class, 'store'])->name('meta.store');
        Route::put('put/{id}', [MetaTagController::class, 'update'])->name('meta.put');
        Route::delete('destroy/{id}', [MetaTagController::class, 'destroy'])->name('meta.destroy');
    });

    Route::prefix('etc')->group(function () {
        // Route::prefix('sosmed')->group(function () {
        //     Route::get('/', [SocialMediaController::class, 'index'])->name('sosmed.index');
        //     Route::post('store', [SocialMediaController::class, 'store'])->name('sosmed.store');
        //     Route::put('put/{id}', [SocialMediaController::class, 'update'])->name('sosmed.put');
        //     Route::delete('destroy/{id}', [SocialMediaController::class, 'destroy'])->name('sosmed.destroy');
        // });
        // Route::prefix('contact')->group(function () {
        //     Route::get('/', [ContactController::class, 'index'])->name('contact.index');
        //     Route::post('store', [ContactController::class, 'store'])->name('contact.store');
        //     Route::put('put/{id}', [ContactController::class, 'update'])->name('contact.put');
        //     Route::delete('destroy/{id}', [ContactController::class, 'destroy'])->name('contact.destroy');
        // });
        Route::prefix('faq')->group(function () {
            Route::prefix('section')->group(function () {
                Route::prefix('banner')->group(function () {
                    Route::get('/', [FaqController::class, 'indexBanner'])->name('section.faq.banner.index');
                    Route::post('store', [FaqController::class, 'storeBannerFaq'])->name('section.faq.banner.store');
                    Route::put('put/{id}', [FaqController::class, 'updateBannerFaq'])->name('section.faq.banner.put');
                });
                Route::prefix('main')->group(function () {
                    Route::get('/', [FaqController::class, 'index'])->name('faq.index');
                    Route::post('content/store', [FaqController::class, 'storeContentFaq'])->name('faq.storeContentFaq');
                    Route::put('content/put/{id}', [FaqController::class, 'updateContentFaq'])->name('faq.updateContentFaq');
                    Route::post('store', [FaqController::class, 'store'])->name('faq.store');
                    Route::put('put/{id}', [FaqController::class, 'update'])->name('faq.put');
                    Route::delete('destroy/{id}', [FaqController::class, 'destroy'])->name('faq.destroy');
                });
            });
        });
        Route::prefix('tnc')->group(function () {
            Route::prefix('section')->group(function () {
                Route::prefix('banner')->group(function () {
                    Route::get('/', [TnCController::class, 'indexBanner'])->name('tnc.indexBanner');
                    Route::post('content/store', [TnCController::class, 'storeBannerTnc'])->name('section.tnc.banner.store');
                    Route::put('content/put/{id}', [TnCController::class, 'updateBannerTnc'])->name('section.tnc.banner.put');
                });
                Route::prefix('notes-delivery')->group(function () {
                    Route::get('/', [TnCController::class, 'index'])->name('tnc.index');
                    Route::post('store', [TnCController::class, 'store'])->name('tnc.store');
                    Route::put('put/{id}', [TnCController::class, 'update'])->name('tnc.put');
                    Route::delete('destroy/{id}', [TnCController::class, 'destroy'])->name('tnc.destroy');
                });
                Route::prefix('skfm')->group(function () {
                    Route::get('/', [TnCController::class, 'indexSkFm'])->name('section.tnc.sk.index');
                    Route::post('store', [TnCController::class, 'storeSkFm'])->name('section.tnc.sk.store');
                    Route::put('put/{id}', [TnCController::class, 'updateSkFm'])->name('section.tnc.sk.put');
                });
                Route::prefix('garansi')->group(function () {
                    Route::get('/', [TnCController::class, 'indexGaransi'])->name('section.tnc.garansi.index');
                    Route::post('store', [TnCController::class, 'storeGaransi'])->name('section.tnc.garansi.store');
                    Route::put('put/{id}', [TnCController::class, 'updateGaransi'])->name('section.tnc.garansi.put');
                });
                Route::prefix('how-to-eat')->group(function () {
                    Route::get('/', [TnCController::class, 'indexHte'])->name('section.tnc.hte.index');
                    Route::post('store', [TnCController::class, 'storeHte'])->name('section.tnc.hte.store');
                    Route::put('put/{id}', [TnCController::class, 'updateHte'])->name('section.tnc.hte.put');
                });
                Route::prefix('reschedule')->group(function () {
                    Route::get('/', [TnCController::class, 'indexReschedule'])->name('section.tnc.reschedule.index');
                    Route::post('store', [TnCController::class, 'storeReschedule'])->name('section.tnc.reschedule.store');
                    Route::put('put/{id}', [TnCController::class, 'updateReschedule'])->name('section.tnc.reschedule.put');
                });
            });
        });
    });

    Route::prefix('partnership')->group(function () {
        Route::prefix('main')->group(function () {
            Route::get('/', [PartnershipController::class, 'index'])->name('partnership.index');
            Route::post('store', [PartnershipController::class, 'store'])->name('partnership.store');
            Route::put('put/{id}', [PartnershipController::class, 'update'])->name('partnership.put');
            Route::delete('destroy/{id}', [PartnershipController::class, 'destroy'])->name('partnership.destroy');
            Route::post('section/store', [PartnershipSectionController::class, 'storeSectionPartnership'])->name('partnership.section.store');
            Route::put('section/put/{id}', [PartnershipSectionController::class, 'updateSectionPartnership'])->name('partnership.section.put');
        });
        Route::prefix('banner')->group(function () {
            Route::get('/', [PartnershipSectionController::class, 'indexBanner'])->name('section.partnership.banner.index');
            Route::post('store', [PartnershipSectionController::class, 'storeSectionBanner'])->name('section.partnership.banner.store');
            Route::put('put/{id}', [PartnershipSectionController::class, 'updateSectionBanner'])->name('section.partnership.banner.put');
        });
        Route::prefix('tag')->group(function () {
            Route::get('/', [PartnershipSectionController::class, 'indexContentTag'])->name('section.partnership.tag.index');
            Route::post('store', [PartnershipSectionController::class, 'storeSectionTag'])->name('section.partnership.tag.store');
            Route::put('put/{id}', [PartnershipSectionController::class, 'updateSectionTag'])->name('section.partnership.tag.put');
        });
        Route::prefix('collaborate')->group(function () {
            Route::get('/', [PartnershipSectionController::class, 'indexContentCollaborate'])->name('section.partnership.collaborate.index');
            Route::post('store', [PartnershipSectionController::class, 'storeSectionCollaborate'])->name('section.partnership.collaborate.store');
            Route::put('put/{id}', [PartnershipSectionController::class, 'updateSectionCollaborate'])->name('section.partnership.collaborate.put');
        });
        Route::prefix('hero')->group(function () {
            Route::get('/', [PartnershipSectionController::class, 'indexContentHero'])->name('section.partnership.hero.index');
            Route::post('store', [PartnershipSectionController::class, 'storeSectionHero'])->name('section.partnership.hero.store');
            Route::put('put/{id}', [PartnershipSectionController::class, 'updateSectionHero'])->name('section.partnership.hero.put');
        });
    });

    Route::prefix('master')->group(function () {
        Route::get('section-category', [MasterSectionCategoryController::class, 'index'])->name('scategory.index');
        Route::post('section-category/store', [MasterSectionCategoryController::class, 'store'])->name('scategory.store');
        Route::put('section-category/put/{id}', [MasterSectionCategoryController::class, 'update'])->name('scategory.put');
        Route::delete('section-category/destroy/{id}', [MasterSectionCategoryController::class, 'destroy'])->name('scategory.destroy');
        Route::get('section-content', [SectionContentController::class, 'index'])->name('section.index');

        Route::prefix('konten')->group(function () {
            Route::prefix('testimoni')->group(function () {
                Route::get('/', [TestimoniController::class, 'index'])->name('testimoni.index');
                Route::post('section/store', [TestimoniController::class, 'storeContentTestimoni'])->name('testimoni.storeContentTestimoni');
                Route::put('section/put/{id}', [TestimoniController::class, 'updateContentTestimoni'])->name('testimoni.updateContentTestimoni');
                Route::post('store', [TestimoniController::class, 'store'])->name('testimoni.store');
                Route::put('put/{id}', [TestimoniController::class, 'update'])->name('testimoni.put');
                Route::delete('destroy/{id}', [TestimoniController::class, 'destroy'])->name('testimoni.destroy');
            });
            Route::prefix('certificate')->group(function () {
                Route::get('/', [CertificateController::class, 'index'])->name('certificate.index');
                Route::post('store', [CertificateController::class, 'store'])->name('certificate.store');
                Route::put('put/{id}', [CertificateController::class, 'update'])->name('certificate.put');
                Route::delete('destroy/{id}', [CertificateController::class, 'destroy'])->name('certificate.destroy');
            });
            Route::prefix('program')->group(function () {
                Route::get('/', [ProgramController::class, 'index'])->name('program.index');
                Route::post('section/store', [ProgramController::class, 'storeContentProgram'])->name('program.store.content');
                Route::put('section/put/{id}', [ProgramController::class, 'updateContentProgram'])->name('program.update.content');
                Route::post('store', [ProgramController::class, 'store'])->name('program.store');
                Route::put('put/{id}', [ProgramController::class, 'update'])->name('program.put');
                Route::delete('destroy/{id}', [ProgramController::class, 'destroy'])->name('program.destroy');
            });
            Route::prefix('statistic')->group(function () {
                Route::get('/', [OperationalStatisticController::class, 'index'])->name('statistic.index');
                Route::post('content/store', [OperationalStatisticController::class, 'storeContentStats'])->name('statistic.storeContent');
                Route::put('content/put/{id}', [OperationalStatisticController::class, 'updateContentStats'])->name('statistic.putContent');
                Route::post('store', [OperationalStatisticController::class, 'store'])->name('statistic.store');
                Route::put('put/{id}', [OperationalStatisticController::class, 'update'])->name('statistic.put');
                Route::delete('destroy/{id}', [OperationalStatisticController::class, 'destroy'])->name('statistic.destroy');
            });
            Route::prefix('partnership')->group(function () {
                Route::get('/', [PartnershipController::class, 'indexHomePartnership'])->name('partnershipHome.index');
                Route::post('section/store', [PartnershipController::class, 'storeSectionPartnership'])->name('section.partnershipHome.store');
                Route::put('section/put/{id}', [PartnershipController::class, 'updateSectionPartnership'])->name('section.partnershipHome.put');
                Route::post('store', [PartnershipController::class, 'storeHomePartnership'])->name('partnershipHome.store');
                Route::put('put/{id}', [PartnershipController::class, 'updateHomePartnership'])->name('partnershipHome.put');
                Route::delete('destroy/{id}', [PartnershipController::class, 'destroyHomePartnership'])->name('partnershipHome.destroy');
            });
            Route::prefix('meal')->group(function () {
                Route::get('/', [MealController::class, 'index'])->name('meal.index');
                Route::post('store', [MealController::class, 'store'])->name('meal.store');
                Route::post('section/store', [MealController::class, 'storeContentMeal'])->name('meal.store.content');
                Route::put('section/put/{id}', [MealController::class, 'updateContentMeal'])->name('meal.update.content');
                Route::put('put/{id}', [MealController::class, 'update'])->name('meal.put');
                Route::delete('destroy/{id}', [MealController::class, 'destroy'])->name('meal.destroy');
            });
            Route::prefix('menu')->group(function () {
                Route::get('/', [MenuController::class, 'index'])->name('batch-menu.index');
                Route::post('store', [MenuController::class, 'store'])->name('batch-menu.store');
                Route::put('put', [MenuController::class, 'update'])->name('batch-menu.put');
                Route::delete('destroy/{id}', [MenuController::class, 'destroy'])->name('batch-menu.destroy');
            });
            Route::prefix('batch')->group(function () {
                Route::get('/', [BatchController::class, 'index'])->name('batch.index');
                Route::get('sync', [BatchController::class, 'syncBatch'])->name('sync.index');
                Route::post('store', [BatchController::class, 'store'])->name('batch.store');
                Route::put('put/{id}', [BatchController::class, 'update'])->name('batch.put');
                Route::delete('destroy/{id}', [BatchController::class, 'destroy'])->name('batch.destroy');
            });
        });
    });
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
