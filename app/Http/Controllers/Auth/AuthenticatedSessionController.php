<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function otpView()
    {
    }

    public function store(LoginRequest $request)
    {

        // dd($request->all());

        // $user = User::where('username', $request->username)->first();
        // if ($user) {
        //     if (Hash::check($request->password, $user->password)) {
        //         $request->authenticate();
        //         $request->session()->regenerate();
        //         return redirect(RouteServiceProvider::HOME);
        //     } else {
        //         throw ValidationException::withMessages([
        //             'username' => __('auth.failed'),
        //         ]);
        //     }
        // } else {
        //     $request->session()->regenerate();
        //     throw ValidationException::withMessages([
        //         'username' => __('auth.incorrect'),
        //     ]);
        // }
        $validator = Validator::make($request->all(), [
            'loginId' => 'required',
            // 'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // $user = User::where('username', $request->loginId)
        //     ->orWhere('ehrms_id', $request->loginId)
        //     ->first();
        // if ($user) {
        //     if ($user->is_active == 1) {
        //         $userMobile = $user->mobile;
        //         // return redirect()->route('auth.otp', $userMobile);

        //         // $this->otpView();
        //         // $request->authenticate();
        //     }
        // } else {
        //     $errors = "This user is not activated";
        //     return redirect()->back()->withErrors($errors);
        // }
        $request->authenticate();
        $request->session()->regenerate();
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
