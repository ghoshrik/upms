<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // use AuthenticatesUsers;
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'loginId' => 'required',
            // 'password' => 'required|string',
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function sendOtp(Request $request)
    {
        dd($request);
    }


    public function authenticate()
    {
        // dd($this->boolean('remember'));
        $this->ensureIsNotRateLimited();
        // if (!Auth::attempt($this->only('loginId'), $this->filled('remember'))) {
        //     RateLimiter::hit($this->throttleKey());

        //     throw ValidationException::withMessages([
        //         'loginId' => __('auth.failed'),
        //     ]);
        // }

        $user = User::where('username', $this->loginId)
            ->orWhere('ehrms_id', $this->loginId)
            ->first();
        if ($user) {
            // dd($user);
            if ($user->is_active == 1) {

                $userMobile = $user->mobile;
                // return redirect()->route('auth.otp');
                // if ($user) {
                //     return redirect()->route('auth.otp')->withSuccess('Login OTP has been sent to your mobile');
                // } else {
                //     throw ValidationException::withMessages([
                //         'password' => __('This password is not valid'),
                //     ]);
                // }

                // if (!$user || !Hash::check($this->password, $user->password)) {
                //     RateLimiter::hit($this->throttleKey());
                //     throw ValidationException::withMessages([
                //         'loginId' => __('auth.failed'),
                //     ]);
                // }
                // Auth::login($user, $this->boolean('remember'));
                // RateLimiter::clear($this->throttleKey());
            } else {
                throw ValidationException::withMessages([
                    'loginId' => __('This user is not activated'),
                ]);
            }
        } else {
            throw ValidationException::withMessages([
                'loginId' => __('auth.failed'),
            ]);
        }


        // if (!$user || !Hash::check($this->password, $user->password)) {
        //     RateLimiter::hit($this->throttleKey());

        //     throw ValidationException::withMessages([
        //         'loginId' => __('auth.failed'),
        //     ]);
        // }


    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'loginId' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->input('loginId')) . '|' . $this->ip();
    }
}