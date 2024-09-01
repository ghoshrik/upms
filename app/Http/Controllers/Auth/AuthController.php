<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VerificationCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginPage()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        } else {
            return view('auth.login');
        }
    }

    public function generateOtp($user)
    {
        // dd($user);
        // dd(base64_decode($user->id));
        # User Does not Have Any Existing OTP
        $verificationCode = VerificationCode::where('user_id', $user)->latest()->first();
        // dd($verificationCode);
        $now = Carbon::now();

        if ($verificationCode && $now->isBefore($verificationCode->expire_at)) {
            return $verificationCode;
        }

        // Create a New OTP
        return VerificationCode::create([
            'user_id' => $user,
            'otp' => rand(123456, 999999),
            'expire_at' => Carbon::now()->addMinutes(2),
        ]);
    }

    public function Userlogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_id' => 'required',
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->email_id)
            ->orWhere('username', $request->email_id)
            ->first();
        if ($user) {
            session([
                'user_data' => $user,
                'curr_role' => $user->getRoleNames()[0],
            ]);
            /* Super Admin*/
            if ($user->is_active == 1 && $user->is_admin == 1) {
                if ($user && Hash::check($request->password, $user->password)) {
                    Auth::login($user);
                    // dd($request->session()->put('user', $user));
                    return redirect()->route('dashboard');
                } else {
                    throw ValidationException::withMessages([
                        'email_id' => __('auth.failed'),
                    ]);
                }
            } elseif ($user->is_active == 1) {
                if ($user && Hash::check($request->password, $user->password)) {
                    $resp = $this->generateOtp($user->id);
                    $phoneNumberMasked = preg_replace('/(\d{3})(\d{3})(\d{4})/', 'XXXXXX$3', $user->mobile); // Masked phone number
                    // dd($resp->otp);
                    $messageSend = "Your Mobile Number is " . $phoneNumberMasked . " " . "Your OTP is " . $resp->otp;
                    return redirect()->route('auth.verify', ['user_id' => Crypt::encryptString($user->id)])->with('status', $messageSend);
                    // dd($resp);
                } else {
                    throw ValidationException::withMessages([
                        'email_id' => __('auth.failed'),
                    ]);
                }
            } else {
                return redirect()->route('auth.signin')->with('error', 'This user is not activated');
            }
        } else {
            return redirect()->route('auth.signin')->with('error', 'User not Exists');
        }
    }
    public function verifyOTP($userId)
    {

        // dd(base64_decode($userId));

        $userdtls = User::select('emp_name')->where('id', Crypt::decryptString($userId))->first();
        return view('auth.otpScreen')->with(['user_id' => Crypt::decryptString($userId), 'userdtls' => $userdtls]);
    }
    public function LoginWithOTP(Request $request)
    {
        // dd($request->all());
        // dd(base64_decode($request->userId));
        // dd(implode('', $request->verifyOtp));

        // $validator = Validator::make($request->all(), [
        //     // 'verifyOtp' => 'required|numeric',
        //     'user_id' => 'required|exists:users,id'
        //     // 'password' => 'required|min:6',
        // ]);
        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }
        // $otpcode = implode('', $request->verifyOtp);
        // implode('"',$otpcode);
        // dd(implode(' ', $otpcode));
        // dd(VerificationCode::where('user_id', $request->user_id)->where('otp', $otpcode)->first());
        // dd($otpcode);

        $verificationCode = VerificationCode::select('verification_codes.*')->where('user_id', Crypt::decryptString($request->userId))->where('otp', $request->otpnum)->first();
        // dd($verificationCode);
        $now = Carbon::now();
        if (!$verificationCode) {
            // return redirect()->back()->with('error', 'Your OTP is not correct');
            return response()->json(['error' => false, 'message' => 'Please Enter correct OTP']);
        } elseif ($verificationCode && $now->isAfter($verificationCode->expire_at)) {
            // return redirect()->route('auth.signin')->with('error', 'Your OTP has been expired');
            return response()->json(['success' => false, 'message' => 'Your OTP has been expired']);
        }
        $user = User::whereId(Crypt::decryptString($request->userId))->first();

        if ($user) {
            $user->update(['is_verified' => true]);

            $verificationCode->update([
                'expire_at' => Carbon::now(),
            ]);
            Auth::login($user);

            // return redirect()->route('dashboard');
            return response()->json(['success' => true, 'status' => 'Your OTP is verified']);
        }
        // return redirect()->route('auth.signin')->with('error', 'Your OTP is Not Correct');
        // return response()->json(['success'=>false,'']);
    }
    public function resendOTP($userid)
    {
        // dd("ff");
        $userId = Crypt::decryptString($userid);
        $user_id = User::where('id', $userId)->first();
        // dd($user_id);
        $resp = $this->generateOtp($user_id->id);
        $phoneNumberMasked = preg_replace('/(\d{3})(\d{3})(\d{4})/', 'XXXXXX$3', $user_id->mobile);
        $messageSend = "Your Mobile Number is " . $phoneNumberMasked . " " . "Your OTP is " . $resp->otp;
        return redirect()->route('auth.verify', ['user_id' => Crypt::encryptString($resp->user_id)])->with('status', $messageSend);
    }
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerate(true);
        $request->session()->regenerateToken();
        return redirect()->route('auth.signin')->with('success', 'Logout Successfully');
    }
}
