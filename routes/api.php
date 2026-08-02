<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CitizenController;
use App\Http\Controllers\CitizenDocumentController;
use App\Http\Controllers\FamilyCardController;

use App\Http\Controllers\LetterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SosialAssistanceApplicantController;
use App\Http\Controllers\SosialAssistanceCategoryController;
use App\Http\Controllers\SosialAssistanceController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;






Route::middleware('auth:sanctum')->group(function (){
    
    Route::apiResource('/citizen', CitizenController::class);
    Route::apiResource('/family-card', FamilyCardController::class);
    Route::apiResource('/citizen-document', CitizenDocumentController::class);
    Route::apiResource('/letter', LetterController::class);

    Route::get('profile', [ProfileController::class, 'index']);
    Route::post('profile', [ProfileController::class, 'store']);
    Route::put('profile', [ProfileController::class, 'update']);
});

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me'])->name('me');