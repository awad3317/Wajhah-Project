<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BankController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\RegionController;
use App\Http\Controllers\API\Auth\OtpController;
use App\Http\Controllers\API\OwnerAccountController;
use App\Http\Controllers\API\Auth\UserAuthController;
use App\Http\Controllers\API\EstablishmentController;
use App\Http\Controllers\API\EstablishmentRuleController;
use App\Http\Controllers\API\EstablishmentTypeController;
use App\Http\Controllers\API\Auth\ForgetPasswordController;
use App\Http\Controllers\API\EstablishmentFeatureController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum','check.banned'])->group(function () {
    Route::put('/user/{id}', [UserController::class, 'update']);
    Route::get('/bank', [BankController::class, 'index']);
    Route::apiResource('/acount', OwnerAccountController::class)->except(['index','show']);
    Route::apiResource('/establishment', EstablishmentController::class)->except(['index','show']);
    Route::apiResource('/establishmentFeature', EstablishmentFeatureController::class)->except(['index','show']);
    Route::apiResource('/establishmentRule', EstablishmentRuleController::class)->except(['index','show']);
    
});

    //           Auth Route          //
Route::post('/register',[UserAuthController::class,'register']);
Route::post('/login',[UserAuthController::class,'login']);
Route::post('/verifyOtpAndLogin',[OTPController::class,'verifyOtpAndLogin']);
Route::post('/resendOTP',[OTPController::class,'resendOTP']);

    //           Forget Password     //
Route::post('/forgetPassword', [ForgetPasswordController::class,'forgetPassword']);
Route::post('/resetPassword', [ForgetPasswordController::class,'resetPassword']);

Route::get('/establishmentType', [EstablishmentTypeController::class, 'index']);

Route::get('/regions/parents', [RegionController::class,'getParents']);
Route::get('/regions/{id}/children', [RegionController::class,'getChildren']);
Route::get('/region',[RegionController::class,'index']);
