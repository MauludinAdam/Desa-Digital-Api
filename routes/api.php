<?php

use App\Http\Controllers\AnaliticsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BumdesController;
use App\Http\Controllers\BumdesManajerController;
use App\Http\Controllers\BumdesProductController;
use App\Http\Controllers\BumdesUnitsController;
use App\Http\Controllers\CitizenController;
use App\Http\Controllers\CitizenDocumentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\FamilyCardController;
use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\LetterAttachmentController;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\LetterTypeController;
use App\Http\Controllers\OccupationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileVillageController;
use App\Http\Controllers\ReligionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SosialAssistanceApplicantController;
use App\Http\Controllers\SosialAssistanceCategoryController;
use App\Http\Controllers\SosialAssistanceController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;






Route::middleware('auth:sanctum')->group(function (){
    Route::prefix('reports')->group(function(){
        Route::get('/citizen', [ReportController::class, 'citizen']);
        Route::get('/family-card', [ReportController::class, 'familyCard']);
        Route::get('/sosial-assistance-applicant', [ReportController::class, 'sosialAssistanceApplicant']);
    });

    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/analitic', [AnaliticsController::class, 'index']);

    Route::get('/citizen/head-of-family-options', [CitizenController::class, 'headOfFamilyOptions'])
    ->middleware('role:admin|headman');
    Route::apiResource('/citizen', CitizenController::class)
    ->middlewareFor(['index', 'show'], 'role:admin|headman')
    ->middlewareFor(['store','update','destroy'], 'role:admin');

    Route::apiResource('/family-card', FamilyCardController::class)
    ->middlewareFor(['index','show'], 'role:admin|headman')
    ->middlewareFor(['store','update','destroy'], 'role:admin');

    Route::apiResource('/family-member', FamilyMemberController::class)
    ->middlewareFor(['index','show'], 'role:admin|headman')
    ->middlewareFor(['store','update','destroy'], 'role:admin');

    Route::apiResource('/citizen-document', CitizenDocumentController::class)
    ->middlewareFor(['index','show'], 'role:admin|headman')
    ->middlewareFor(['store','update','destroy'], 'role:admin');

    Route::patch('/letter/{id}/approved',[LetterController::class, 'approved']);
    Route::patch('/letter/{id}/rejected', [LetterController::class, 'rejected']);
    Route::apiResource('/letter', LetterController::class)
    ->middlewareFor(['index','show'], 'role:admin|headman')
    ->middlewareFor(['store','update','destroy'], 'role:admin');

    Route::apiResource('/letter-type', LetterTypeController::class)
    ->middlewareFor(['index','show'], 'role:admin|headman')
    ->middlewareFor(['store','update','destroy'], 'role:admin');

   
    Route::apiResource('/letter-attachment', LetterAttachmentController::class)
    ->middlewareFor(['index','show'], 'role:admin|headman')
    ->middlewareFor(['store','update','destroy'], 'role:admin');

    Route::apiResource('/occupation', OccupationController::class)
    ->middleware('role:admin');

    Route::apiResource('/education', EducationController::class)
    ->middleware('role:admin');

    Route::apiResource('/religion', ReligionController::class)
    ->middleware('role:admin');

    Route::apiResource('/sosial-assistance-category', SosialAssistanceCategoryController::class)
    ->middleware('role:admin');

    Route::apiResource('/sosial-assistance', SosialAssistanceController::class)
    ->middleware('role:admin|headman');

    Route::apiResource('/sosial-assistance-applicant', SosialAssistanceApplicantController::class)
    ->middlewareFor(['index','show'], 'role:admin|headman')
    ->middlewareFor(['store','update','destroy'], 'role:admin');
    
    Route::put('sosial-assistance-applicant/{id}/upload', [SosialAssistanceApplicantController::class, 'uploadTransferProof'])
    ->middleware('role:headman');
    Route::patch('/sosial-assistance-applicant/{id}/approved', [SosialAssistanceApplicantController::class, 'approved'])
    ->middleware('role:headman');
    Route::patch('/sosial-assistance-applicant/{id}/rejected', [SosialAssistanceApplicantController::class, 'rejected'])
    ->middleware('role:headman');

    Route::get('/bumdes', [BumdesController::class, 'show'])
    ->middleware('role:admin|headman');
    Route::post('/bumdes', [BumdesController::class, 'update'])
    ->middleware('role:admin');

    Route::apiResource('/bumdes-manajer', BumdesManajerController::class)
    ->middlewareFor(['index', 'show'], 'role:admin|headman')
    ->middlewareFor(['store','update','destroy'], 'role:admin');

    Route::apiResource('/bumdes-unit', BumdesUnitsController::class)
    ->middlewareFor(['index','show'], 'role:admin|headman')
    ->middlewareFor(['store','update','destroy'], 'role:admin');

    Route::apiResource('/bumdes-product', BumdesProductController::class)
    ->middlewareFor(['index','show'], 'role:admin|headman')
    ->middlewareFor(['store','update','destroy'], 'role:admin');

    Route::get('profile', [ProfileVillageController::class, 'show'])
    ->middleware('role:admin|headman');

    Route::post('profile', [ProfileVillageController::class, 'update'])
    ->middleware('role:admin');
});

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me'])->name('me');
Route::middleware('auth:sanctum')->put('/me', [AuthController::class, 'update'])->name('me.update');