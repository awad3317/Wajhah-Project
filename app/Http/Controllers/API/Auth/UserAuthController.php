<?php

namespace App\Http\Controllers\API\Auth;

use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

class UserAuthController extends Controller
{
    /**
     * Create a new class instance.
     */
    public function __construct(private UserRepository $UserRepository,private OtpService $otpService)
    {
        //
    }
    public function register(Request $request){
        $fields=$request->validate([
            'name'=>['required','string','max:100'],
            'phone'=>['required','string','min:9','max:15',Rule::unique('users')],
            'password' => ['required','string','min:6','confirmed',],
        ]);
        // Store the new user using the UserRepository
        $fields['user_type']='user';
        $user=$this->UserRepository->store($fields);

        // Generate a random OTP and prepare it for sending
        $otp=$this->otpService->generateOTP($user->phone,'account_creation');

        // Send an email with the OTP code to the user's email address
        // SendOtpEmailJob::dispatch($user->email, $otp);
        // Mail::to($user->email)->send(new OtpMail($otp));

        return ApiResponseClass::sendResponse($user,'تم إرسال رمز التحقق الى رقم الهاتف :'. $user->phone.  ' : '. $otp);
    }
   
}
