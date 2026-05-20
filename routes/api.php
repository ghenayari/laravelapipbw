<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CourseController;
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
// Endpoint untuk mengambil data kursus
Route::get('/courses', [CourseController::class, 'index']);


// Endpoint untuk melihat data (Method GET)
Route::get('/courses', [CourseController::class, 'index']);

// Endpoint untuk menambah data (Method POST)
Route::post('/courses', [CourseController::class, 'store']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
