<?php

use App\Http\Controllers\Api\BorrowingApiController;
use App\Http\Controllers\Api\GenreApiController;
use App\Http\Controllers\Api\MangaApiController;
use App\Http\Controllers\Api\MemberApiController;
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

Route::apiResource('genres', GenreApiController::class);
Route::apiResource('mangas', MangaApiController::class);
Route::apiResource('members', MemberApiController::class);
Route::apiResource('borrowings', BorrowingApiController::class);

// Backward-compatible singular aliases for API testing tools.
Route::apiResource('genre', GenreApiController::class);
Route::apiResource('manga', MangaApiController::class);
Route::apiResource('member', MemberApiController::class);
Route::apiResource('borrowing', BorrowingApiController::class);
