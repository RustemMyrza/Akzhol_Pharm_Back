<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->scopeBindings()->group(function () {
    Route::get('index', [\App\Http\Controllers\HomeController::class, 'index'])->name('index');

    // Route::resource('notificationMessages', \App\Http\Controllers\Admin\NotificationMessageController::class);
    // Route::prefix('notificationMessages/{notificationMessage}/')
    //     ->name('notificationMessages.')
    //     ->group(function () {
    //         Route::post('send-messages', [\App\Http\Controllers\Admin\NotificationMessageController::class, 'sendMessages'])->name('sendMessages');
    //         Route::post('retry-send-messages', [\App\Http\Controllers\Admin\NotificationMessageController::class, 'retrySendMessages'])->name('retrySendMessages');
    //     });

    Route::resource('seoPages', \App\Http\Controllers\Admin\SeoPageController::class);
    Route::prefix('seoPages/{seoPage}')->name('seoPages.')->group(function () {
        Route::post('updateIsActive', [\App\Http\Controllers\Admin\SeoPageController::class, 'updateIsActive']);
    });

    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except('show');
    Route::prefix('categories/{category}')
        ->name('categories.')
        ->group(function () {
            Route::post('updateIsActive', [\App\Http\Controllers\Admin\CategoryController::class, 'updateIsActive']);
            Route::post('updateIsNew', [\App\Http\Controllers\Admin\CategoryController::class, 'updateIsNew']);
            Route::get('seo/edit', [\App\Http\Controllers\Admin\CategorySeoController::class, 'edit'])->name('editSeo');
            Route::patch('seo/update', [\App\Http\Controllers\Admin\CategorySeoController::class, 'update'])->name('updateSeo');
        });
    Route::prefix('categories/{category}')
        ->group(function () {
            Route::resource('subCategories', \App\Http\Controllers\Admin\SubCategoryController::class)->except('show');
            Route::prefix('subCategories/{subCategory}')->name('subCategories.')->group(function () {
                Route::post('updateIsActive', [\App\Http\Controllers\Admin\SubCategoryController::class, 'updateIsActive']);
            });
        });

    Route::resource('cities', \App\Http\Controllers\Admin\CityController::class)->except('show');
    Route::prefix('cities/{city}')->name('cities.')->group(function () {
        Route::post('/updateIsActive', [\App\Http\Controllers\Admin\CityController::class, 'updateIsActive']);
    });

    Route::resource('filters', \App\Http\Controllers\Admin\FilterController::class)->except('show');
    Route::prefix('filters/{filter}')->group(function () {
        Route::name('filters.')->group(function () {
            Route::post('/updateIsActive', [\App\Http\Controllers\Admin\FilterController::class, 'updateIsActive']);
        });

        Route::resource('filterItems', \App\Http\Controllers\Admin\FilterItemController::class)->except('show');
        Route::prefix('filterItems/{filterItem}')->name('filterItems.')->group(function () {
            Route::post('/updateIsActive', [\App\Http\Controllers\Admin\FilterItemController::class, 'updateIsActive']);
        });
    });

    Route::resource('features', \App\Http\Controllers\Admin\FeatureController::class)->except('show');
    Route::prefix('features/{feature}')->group(function () {
        Route::name('features.')->group(function () {
            Route::post('/updateIsActive', [\App\Http\Controllers\Admin\FeatureController::class, 'updateIsActive']);
        });

        Route::resource('featureItems', \App\Http\Controllers\Admin\FeatureItemController::class)->except('show');
        Route::prefix('featureItems/{featureItem}')->name('featureItems.')->group(function () {
            Route::post('/updateIsActive', [\App\Http\Controllers\Admin\FeatureItemController::class, 'updateIsActive']);
        });
    });

//    Route::resource('brands', \App\Http\Controllers\Admin\BrandController::class)->except('show');
//    Route::prefix('brands/{brand}')->name('brands.')->group(function () {
//        Route::post('/updateIsActive', [\App\Http\Controllers\Admin\BrandController::class, 'updateIsActive']);
//    });

//    Route::resource('countries', \App\Http\Controllers\Admin\CountryController::class)->except('show');
//    Route::prefix('countries/{country}')->name('countries.')->group(function () {
//        Route::post('/updateIsActive', [\App\Http\Controllers\Admin\CountryController::class, 'updateIsActive']);
//    });

    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);
    Route::post('orders/export', [\App\Http\Controllers\Admin\OrderController::class, 'export'])->name('orders.export');
    Route::prefix('orders/{order}')->group(function () {
        Route::resource('orderProducts', \App\Http\Controllers\Admin\OrderProductController::class)->except('show', 'edit', 'create');
    });

    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('brands', \App\Http\Controllers\Admin\BrandController::class);

    Route::post('products/export', [\App\Http\Controllers\Admin\ProductImportController::class, 'export'])->name('products.export');
    Route::post('products/import', [\App\Http\Controllers\Admin\ProductImportController::class, 'import'])->name('products.import');
    Route::post('products/importImages', [\App\Http\Controllers\Admin\ProductImportController::class, 'importImages'])->name('products.importImages');
    Route::post('products/importDocuments', [\App\Http\Controllers\Admin\ProductImportController::class, 'importDocuments'])->name('products.importDocuments');
    Route::post('products/importExample', [\App\Http\Controllers\Admin\ProductImportController::class, 'importExample'])->name('products.importExample');

    Route::get('get-filters', [\App\Http\Controllers\Admin\ProductController::class, 'getFilters']);
    Route::get('get-subCategories', [\App\Http\Controllers\Admin\ProductController::class, 'getSubCategories']);

    Route::prefix('products/{product}')->group(function () {
        Route::name('products.')->group(function () {
            Route::post('deleteDocument', [\App\Http\Controllers\Admin\ProductController::class, 'deleteDocument']);
            Route::post('deleteImage', [\App\Http\Controllers\Admin\ProductController::class, 'deleteImage']);

//            Route::post('addDescriptionList', [\App\Http\Controllers\Admin\ProductAjaxController::class, 'addDescriptionList']);
//            Route::post('updateDescriptionList', [\App\Http\Controllers\Admin\ProductAjaxController::class, 'updateDescriptionList']);
//            Route::post('deleteDescriptionList', [\App\Http\Controllers\Admin\ProductAjaxController::class, 'deleteDescriptionList']);

//            Route::post('addInstructionList', [\App\Http\Controllers\Admin\ProductAjaxController::class, 'addInstructionList']);
//            Route::post('updateInstructionList', [\App\Http\Controllers\Admin\ProductAjaxController::class, 'updateInstructionList']);
//            Route::post('deleteInstructionList', [\App\Http\Controllers\Admin\ProductAjaxController::class, 'deleteInstructionList']);

            Route::post('updateIsActive', [\App\Http\Controllers\Admin\ProductController::class, 'updateIsActive']);
            Route::get('seo/edit', [\App\Http\Controllers\Admin\ProductSeoController::class, 'edit'])->name('editSeo');
            Route::patch('seo/update', [\App\Http\Controllers\Admin\ProductSeoController::class, 'update'])->name('updateSeo');
        });

        Route::resource('productImages', \App\Http\Controllers\Admin\ProductImageController::class)->except('show');
        Route::prefix('productImages/{productImage}')->name('productImages.')->group(function () {
            Route::post('updateIsActive', [\App\Http\Controllers\Admin\ProductImageController::class, 'updateIsActive']);
        });
    });

    Route::resource('applications', \App\Http\Controllers\Admin\ApplicationController::class);
    Route::post('applications/export', [\App\Http\Controllers\Admin\ApplicationController::class, 'export'])->name('applications.export');

    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::post('users/export', [\App\Http\Controllers\Admin\UserController::class, 'export'])->name('users.export');
    Route::post('users/import', [\App\Http\Controllers\Admin\UserController::class, 'import'])->name('users.import');
    Route::post('users/importExample', [\App\Http\Controllers\Admin\UserController::class, 'importExample'])->name('users.importExample');

    Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class);
    Route::prefix('banners/{banner}')->name('banners.')->group(function () {
        Route::get('/deleteImage', [\App\Http\Controllers\Admin\BannerController::class, 'deleteImage'])->name('deleteImage');
        Route::post('/updateIsActive', [\App\Http\Controllers\Admin\BannerController::class, 'updateIsActive']);
    });

    // Route::resource('sliders', \App\Http\Controllers\Admin\SliderController::class);
    // Route::prefix('sliders/{slider}')->name('sliders.')->group(function () {
    //     Route::post('/updateIsActive', [\App\Http\Controllers\Admin\SliderController::class, 'updateIsActive']);
    // });

    Route::resource('paymentContent', \App\Http\Controllers\Admin\PaymentContentController::class);
    Route::prefix('paymentContent/{paymentContent}')->name('paymentContent.')->group(function () {
        Route::post('/updateIsActive', [\App\Http\Controllers\Admin\PaymentContentController::class, 'updateIsActive']);
    });
    Route::get('homeContentsEdit', [\App\Http\Controllers\Admin\HomeContentController::class, 'newEdit']);
    Route::resource('homeContents', \App\Http\Controllers\Admin\HomeContentController::class)->except('show', 'destroy');
    Route::resource('catalogContents', \App\Http\Controllers\Admin\DealerContentController::class)->except('show', 'destroy');
    Route::resource('aboutUsContents', \App\Http\Controllers\Admin\AboutUsContentController::class)->except('show', 'destroy');
    Route::post('aboutUsContents/{aboutUsContent}/deleteImage', [\App\Http\Controllers\Admin\AboutUsContentController::class, 'deleteImage']);
    Route::resource('reviewContent', App\Http\Controllers\Admin\ReviewContentController::class)->except('show', 'destroy');
    

    Route::resource('deliveryContents', \App\Http\Controllers\Admin\DeliveryContentController::class)->except('show', 'destroy');
    Route::resource('deliveryFeatures', \App\Http\Controllers\Admin\DeliveryFeatureController::class)->except('index', 'show');
    Route::post('deliveryFeatures/{deliveryFeature}/updateIsActive', [\App\Http\Controllers\Admin\DeliveryFeatureController::class, 'updateIsActive']);

    Route::resource('deliveryLists', \App\Http\Controllers\Admin\DeliveryListController::class)->except('index', 'show');
    Route::post('deliveryLists/{deliveryList}/updateIsActive', [\App\Http\Controllers\Admin\DeliveryListController::class, 'updateIsActive']);

    Route::resource('contacts', \App\Http\Controllers\Admin\ContactController::class)->except('show');
    Route::resource('socials', \App\Http\Controllers\Admin\SocialController::class)->except('show');
    Route::post('socials/{social}/updateIsActive', [\App\Http\Controllers\Admin\SocialController::class, 'updateIsActive']);

    Route::resource('agreements', \App\Http\Controllers\Admin\AgreementController::class)->except('show');
    Route::get('agreements/{agreement}/deleteFile', [\App\Http\Controllers\Admin\AgreementController::class, 'deleteFile'])->name('agreements.deleteFile');

    Route::post('ckeditor/upload-image', [\App\Http\Controllers\Admin\CkeditorController::class, 'uploadImage'])->name('ckeditor.uploadImage');

    Route::middleware('role:developer')->group(function () {
        Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::get('settings/fileManager', [\App\Http\Controllers\Admin\SettingController::class, 'fileManager'])->name('settings.fileManager');
        Route::get('phpinfo', [\App\Http\Controllers\Admin\SettingController::class, 'phpinfo'])->name('settings.phpinfo');

        Route::prefix('settings')->name('commands.')->group(function () {
            Route::post('migrate', [\App\Http\Controllers\Admin\SettingController::class, 'migrate'])->name('migrate');
            Route::post('optimize-clear', [\App\Http\Controllers\Admin\SettingController::class, 'optimizeClear'])->name('optimizeClear');
            Route::post('route-cache', [\App\Http\Controllers\Admin\SettingController::class, 'routeCache'])->name('routeCache');
            Route::post('route-clear', [\App\Http\Controllers\Admin\SettingController::class, 'routeClear'])->name('routeClear');
            Route::post('storage-link', [\App\Http\Controllers\Admin\SettingController::class, 'storageLink'])->name('storageLink');
            Route::post('config-clear', [\App\Http\Controllers\Admin\SettingController::class, 'configClear'])->name('configClear');
            Route::post('config-cache', [\App\Http\Controllers\Admin\SettingController::class, 'configCache'])->name('configCache');
            Route::post('cache-clear', [\App\Http\Controllers\Admin\SettingController::class, 'cacheClear'])->name('cacheClear');
        });
    });
});

