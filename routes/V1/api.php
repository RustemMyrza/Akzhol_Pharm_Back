<?php

use Illuminate\Support\Facades\Route;

Route::prefix('V1')
    ->group(function () {
        Route::get('get-header', \App\Http\Controllers\Api\V1\HeaderController::class);
        Route::get('get-footer', \App\Http\Controllers\Api\V1\FooterController::class);

        Route::prefix('pages')
            ->group(function () {
                Route::get('home', \App\Http\Controllers\Api\V1\HomeController::class);

                Route::get('catalog', \App\Http\Controllers\Api\V1\CategoryController::class);
                Route::get('product', [\App\Http\Controllers\Api\V1\ProductController::class, 'index']);
                Route::get('products/search', [\App\Http\Controllers\Api\V1\ProductController::class, 'search']);

                Route::get('instructions', [\App\Http\Controllers\Api\V1\InstructionController::class, 'index']);
                Route::get('instructions/search', [\App\Http\Controllers\Api\V1\InstructionController::class, 'search']);

                Route::get('payment', \App\Http\Controllers\Api\V1\PaymentContentController::class);
                Route::get('delivery', \App\Http\Controllers\Api\V1\DeliveryContentController::class);
                Route::get('about', \App\Http\Controllers\Api\V1\AboutUsContentController::class);
                Route::get('review', \App\Http\Controllers\Api\V1\ReviewContentController::class);
                Route::get('contacts', \App\Http\Controllers\Api\V1\ContactController::class);
            });

        Route::post('applications/create', \App\Http\Controllers\Api\V1\ApplicationController::class);

        /** Заказы */
        Route::prefix('user')
            ->middleware('auth:sanctum')
            ->group(function () {
                Route::get('profile', [\App\Http\Controllers\Api\V1\UserController::class, 'profile']);
                Route::post('profile', [\App\Http\Controllers\Api\V1\UserController::class, 'updateProfile']);

                Route::get('favorites', [\App\Http\Controllers\Api\V1\FavoriteController::class, 'index']);
                Route::post('favorites/createOrDelete', [\App\Http\Controllers\Api\V1\FavoriteController::class, 'createOrDelete']);

                Route::post('logout', [\App\Http\Controllers\Api\V1\Auth\LoginController::class, 'logout']);

                Route::post('subscriber/save', [\App\Http\Controllers\Api\V1\SubscriberController::class, 'save']);
                Route::post('subscriber/delete', [\App\Http\Controllers\Api\V1\SubscriberController::class, 'delete']);
            });
        Route::get('/subscriber/verify/{token}/{email}', [\App\Http\Controllers\Api\V1\SubscriberController::class, 'verify']);

        /** Заказы */
        Route::prefix('orders')
            ->middleware('auth:sanctum')
            ->group(function () {
                Route::post('create', [\App\Http\Controllers\Api\V1\OrderController::class, 'create']);

                Route::get('current', [\App\Http\Controllers\Api\V1\OrderController::class, 'current']);
                Route::get('deferred', [\App\Http\Controllers\Api\V1\OrderController::class, 'deferred']);
                Route::get('approved', [\App\Http\Controllers\Api\V1\OrderController::class, 'approved']);
                Route::get('declined', [\App\Http\Controllers\Api\V1\OrderController::class, 'declined']);
            });

        Route::post('orders/payment-success', [\App\Http\Controllers\Api\V1\PaymentController::class, 'paymentSuccess']);
        Route::post('orders/payment-failed', [\App\Http\Controllers\Api\V1\PaymentController::class, 'paymentFailed']);

        /** Авторизация и Регистрация */
        Route::prefix('auth')
            ->group(function () {
                Route::post('login', [\App\Http\Controllers\Api\V1\Auth\LoginController::class, 'login']);
                Route::post('registration', [\App\Http\Controllers\Api\V1\Auth\RegisterController::class, 'register']);

                Route::post('/forgot-password', [\App\Http\Controllers\Api\V1\Auth\ForgotPasswordController::class, 'forgotPassword']);
                Route::post('/reset-password', [\App\Http\Controllers\Api\V1\Auth\ResetPasswordController::class, 'resetPassword']);
            });
    });
