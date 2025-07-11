<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailValidationController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/validar-email', [EmailValidationController::class, 'validate']);
    Route::post('/generar-pdf', [PdfController::class, 'generatePdf']);
});

Route::get('/usuario/uso', function () {
    $user = Auth::user();
    return response()->json([
        'usado' => $user->validations_used,
        'limite' => $user->validations_limit,
        'plan' => $user->plan
    ]);
});
