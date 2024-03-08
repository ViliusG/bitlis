<?php

use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ShortUrlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('short-url')->group(function () {
    Route::post('/', [ShortUrlController::class, 'store']);
    Route::delete('/{id}', [ShortUrlController::class, 'destroy'])->whereNumber('id');
});

Route::get('/{key}', [RedirectController::class, 'redirect'])->whereAlphaNumeric('key');
