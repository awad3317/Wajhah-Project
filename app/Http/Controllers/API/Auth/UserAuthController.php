<?php

namespace App\Http\Controllers\API\Auth;

use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Services\HypersenderService;

class UserAuthController extends Controller
{
    /**
     * Create a new class instance.
     */
    public function __construct(private UserRepository $UserRepository,private OtpService $otpService,private HypersenderService $HypersenderService)
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
        $this->HypersenderService->sendTextMessage($user->phone,strval($otp));

        return ApiResponseClass::sendResponse($user,'تم إرسال رمز التحقق الى رقم الهاتف :'. $user->phone);
    }

    public function login(Request $request)
    {
        $fields=$request->validate([
            'phone'=>['required','string'],
            'password' => ['required','string'],
        ]);
        $user=$this->UserRepository->findByPhone($fields['phone']);
        // Check if the user exists and if the password is correct
        if($user && Hash::check($fields['password'], $user->password)){

            if (is_null($user->phone_verified_at)) {
                // Generate a random OTP and prepare it for sending
                $otp=$this->otpService->generateOTP($user->phone,'account_creation');

                $this->HypersenderService->sendTextMessage($user->phone,strval($otp));
            

                return ApiResponseClass::sendError("حسابك غير مفعّل بعد، تم إرسال رمز تحقق جديد إليك.", null,403);
            }
            // if($user->is_banned){
            //     return ApiResponseClass::sendError('الحساب محظور',null,401);
            // }

            // Create a new token for the user
            $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;
            $user->token=$token;
            return ApiResponseClass::sendResponse(['user' => $user], 'User logged in successfully');
        }
         return ApiResponseClass::sendError('Unauthorized', ['error' => 'Invalid credentials'], 401);
        
    }

   
}
