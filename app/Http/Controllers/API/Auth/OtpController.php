<?php

namespace App\Http\Controllers\API\Auth;

use Exception;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Services\HypersenderService;

class OtpController extends Controller
{
    public function __construct(private OtpService $otpService,private UserRepository $UserRepository,private HypersenderService $HypersenderService)
    {
        //
    }

    public function resendOTP(Request $request) {
        $fields=$request->validate([
            'phone'=>['required','string','min:9','max:15',Rule::exists('users','phone')],
        ]);
        try {
            $otp=$this->otpService->generateOTP($fields['phone'],'account_creation');
            $this->HypersenderService->sendTextMessage($fields['phone'],strval($otp));
            return ApiResponseClass::sendResponse(null,'تم إرسال رمز التحقق الى : ' . $fields['phone']);
        } catch (Exception $e) {
            return ApiResponseClass::sendError(null,'Failed to resend OTP. ' . $e->getMessage());
        }
        
    }

    public function verifyOtpAndLogin(Request $request) {
        $fields=$request->validate([
            'phone'=>['required'],
            'otp' => ['required','numeric'],
        ]);
        // Verify the provided OTP using the OTP service
        if($this->otpService->verifyOTP($fields['phone'],$fields['otp'])){
            $user=$this->UserRepository->findByPhone($fields['phone']);

            // Update the user record to mark phone as verified
            $this->UserRepository->update(['phone_verified_at'=>now()],$user->id);
            // Auth::login($user);
            
            // Create a new authentication token for the user
            $token = $user->createToken($user->username . '-AuthToken')->plainTextToken;
            return ApiResponseClass::sendResponse(['user'=>$user,'token'=>$token], 'تم التحقق بنجاح');
        }
        return ApiResponseClass::sendError('رمز التحقق غير صالح او منتهي الصلاحيه',[],400);
    }
}
