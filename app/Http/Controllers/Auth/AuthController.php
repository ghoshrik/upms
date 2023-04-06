<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\VerificationCode;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AuthLoginrequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginPage()
    {
        return view('auth.login');
    }

    public function generateOtp($mobile_no)
    {
        $user = User::where('mobile', $mobile_no)->first();
        // dd($user);
        # User Does not Have Any Existing OTP
        $verificationCode = VerificationCode::where('user_id', $user->id)->latest()->first();
        // dd($verificationCode);
        $now = Carbon::now();

        if ($verificationCode && $now->isBefore($verificationCode->expire_at)) {
            return $verificationCode;
        }

        // Create a New OTP
        return VerificationCode::create([
            'user_id' => $user->id,
            'otp' => rand(123456, 999999),
            'expire_at' => Carbon::now()->addMinutes(2)
        ]);
    }


    public function Userlogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loginId' => 'required',
            // 'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::where('username', $request->loginId)
            ->orWhere('ehrms_id', $request->loginId)
            ->first();
        if ($user) {
            if ($user->is_active == 1) {
                if ($user && Hash::check($request->password, $user->password)) {
                    $resp = $this->generateOtp($user->mobile);
                    $phoneNumberMasked = preg_replace('/(\d{3})(\d{3})(\d{4})/', 'XXXXXX$3', $user->mobile); // Masked phone number
                    // dd($resp->otp);
                    $messageSend = "Your Mobile Number is " . $phoneNumberMasked . " " . "Your OTP is " . $resp->otp;
                    return redirect()->route('auth.verify', ['user_id' => $resp->user_id])->with('status', $messageSend);
                    // dd($resp);
                } else {
                    throw ValidationException::withMessages([
                        'loginId' => __('auth.failed'),
                    ]);
                }
            } else {
                return redirect()->with('errors', 'This user is not activated');
            }
        } else {
            return redirect()->route('auth.signin')->with('error', 'User not Exists');
        }
    }
    public function verifyOTP($userId)
    {

        // dd(base64_decode($userId));

        $userdtls = User::select('emp_name')->where('id', $userId)->first();
        return view('auth.otpScreen')->with(['user_id' => $userId, 'userdtls' => $userdtls]);
    }
    public function LoginWithOTP(Request $request)
    {
        // dd($request->all());
        // dd(implode('', $request->verifyOtp));

        $validator = Validator::make($request->all(), [
            // 'verifyOtp' => 'required|numeric',
            'user_id' => 'required|exists:users,id'
            // 'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $otpcode = implode('', $request->verifyOtp);
        // implode('"',$otpcode);
        // dd(implode(' ', $otpcode));
        // dd(VerificationCode::where('user_id', $request->user_id)->where('otp', $otpcode)->first());
        // dd($otpcode);

        $verificationCode   = VerificationCode::where('user_id', $request->user_id)->where('otp', $otpcode)->first();
        // dd($verificationCode);
        $now = Carbon::now();
        if (!$verificationCode) {
            return redirect()->back()->with('error', 'Your OTP is not correct');
        } elseif ($verificationCode && $now->isAfter($verificationCode->expire_at)) {
            return redirect()->route('auth.signin')->with('error', 'Your OTP has been expired');
        }
        $user = User::whereId($request->user_id)->first();

        if ($user) {
            $user->update(['is_verified' => true]);

            $verificationCode->update([
                'expire_at' => Carbon::now()
            ]);
            Auth::login($user);

            return redirect()->route('dashboard');
        }
        return redirect()->route('auth.signin')->with('error', 'Your OTP is Not Correct');
    }
}
