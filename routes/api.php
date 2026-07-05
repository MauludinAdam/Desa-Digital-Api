<?php

use App\Http\Controllers\DevelopmentApplicantController;
use App\Http\Controllers\DevelopmentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventParticipantController;
use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\HeadOfFamilyController;
use App\Http\Controllers\SosialAssistanceController;
use App\Http\Controllers\SosialAssistanceRecipientController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;







// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiResource('user', UserController::class);
Route::get('user/all/paginated', [UserController::class, 'getAllPaginated']);

Route::apiResource('head-of-family', HeadOfFamilyController::class);
Route::get('head-of-family/all/paginated', [HeadOfFamilyController::class, 'getAllPaginated']);

Route::apiResource('family-member', FamilyMemberController::class);
Route::get('family-member/all/paginated', [FamilyMemberController::class, 'getAllPaginated']);

Route::apiResource('sosial-assistance', SosialAssistanceController::class);
Route::get('sosial-assistance/all/paginated', [SosialAssistanceController::class, 'getAllPaginated']);

Route::apiResource('sosial-assistance-recipient', SosialAssistanceRecipientController::class);
Route::get('sosial-assisntance-recipient/all/paginated', [SosialAssistanceRecipientController::class, 'getAllPaginated']);

Route::apiResource('event', EventController::class);
Route::get('event/all/paginated', [EventController::class, 'getAllPaginated']);

Route::apiResource('event-participant', EventParticipantController::class);
Route::get('event-participant/all/paginated', [EventParticipantController::class, 'getAllPaginated']);

Route::apiResource('development', DevelopmentController::class);
Route::get('development/all/paginated', [DevelopmentController::class, 'getAllPaginated']);

Route::apiResource('development-applicant', DevelopmentApplicantController::class);
Route::get('development-applicant/all/paginated', [DevelopmentApplicantController::class, 'getAllPaginated']);