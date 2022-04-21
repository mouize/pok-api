<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$apiVersion = Config::get('app.version');

Route::prefix($apiVersion)
    ->name($apiVersion.'.')
    ->group(function (): void {
        // Authentication
        Route::post('/login', [AuthController::class, 'login']);

        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::middleware('auth:sanctum')->group(function (): void {
            Route::apiResource('users', UserController::class)->except('store');

            Route::apiResource('companies', CompanyController::class);
            Route::apiResource('products', ProductController::class);
        });
    });
