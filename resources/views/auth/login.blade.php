<x-guest-layout>
    <section class="login-content">
        <div class="row m-0 align-items-center bg-white vh-100">
            <div class="col-md-6">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card card-transparent shadow-none d-flex justify-content-center mb-0 auth-card">
                            <div class="card-body">
                                <a href="{{ route('dashboard') }}" class="navbar-brand d-flex align-items-center mb-3">
                                    {{-- <svg width="30" class="text-primary" viewBox="0 0 30 30" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="-0.757324" y="19.2427" width="28" height="4" rx="2"
                                            transform="rotate(-45 -0.757324 19.2427)" fill="currentColor" />
                                        <rect x="7.72803" y="27.728" width="28" height="4" rx="2"
                                            transform="rotate(-45 7.72803 27.728)" fill="currentColor" />
                                        <rect x="10.5366" y="16.3945" width="16" height="4" rx="2"
                                            transform="rotate(45 10.5366 16.3945)" fill="currentColor" />
                                        <rect x="10.5562" y="-0.556152" width="28" height="4" rx="2"
                                            transform="rotate(45 10.5562 -0.556152)" fill="currentColor" />
                                    </svg> --}}
                                    <img src="{{ asset('images/logo/wb_logo.png') }}" alt="logo">
                                    {{-- <h4 class="logo-title ms-3">{{ env('APP_NAME') }}</h4> --}}
                                        <h4 class="logo-title ms-3">Govt. West Bengal <br><span>UPMS</span></h4>
                                </a>
                                <h2 class="mb-2 text-center">Sign In</h2>
                                <p class="text-center">Login to start your session.</p>
                                <x-auth-session-status class="mb-4" :status="session('status')" />

                                @if (session('error'))
                                    <div class="alert alert-danger" role="alert"> {{ session('error') }}
                                    </div>
                                @endif

                                <!-- Validation Errors -->
                                <x-auth-validation-errors class="mb-4" :error="session('error')" />


                                <form method="POST" action="{{ route('auth.login') }}" data-toggle="validator">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="email" class="form-label" style="color:#000000;">Login ID/HRMS ID</label>
                                                <input type="text" name="loginId"
                                                    class="form-control @error('loginId') is-invalid @enderror"
                                                    autocomplete="off" placeholder="{{ __('enter Login ID/HRMS ID') }}"
                                                    autofocus>
                                                @error('loginId')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- @isset($userMobile) --}}
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="password" class="form-label" style="color:#000000;">Password</label>
                                                <input class="form-control @error('password') is-invalid @enderror"
                                                    type="password" autocomplete="off" placeholder="enter your password"
                                                    name="password" autocomplete="current-password">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- @endisset --}}
                                        {{--
                                        <div class="col-lg-6">
                                            <div class="form-check mb-3">
                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                <label class="form-check-label" for="customCheck1">Remember Me</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <a href="{{ route('auth.recoverpw') }}" class="float-end">Forgot
                                                Password?</a>
                                        </div> --}}
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary">{{ __('Sign In') }} </button>
                                    </div>
                                    {{-- <p class="text-center my-3">or sign in with other accounts?</p>
                           <div class="d-flex justify-content-center">
                              <ul class="list-group list-group-horizontal list-group-flush">
                                 <li class="list-group-item border-0 pb-0">
                                    <a href="#"><img src="{{asset('images/brands/fb.svg')}}" alt="fb"></a>
                                 </li>
                                 <li class="list-group-item border-0 pb-0">
                                    <a href="#"><img src="{{asset('images/brands/gm.svg')}}" alt="gm"></a>
                                 </li>
                                 <li class="list-group-item border-0 pb-0">
                                    <a href="#"><img src="{{asset('images/brands/im.svg')}}" alt="im"></a>
                                 </li>
                                 <li class="list-group-item border-0 pb-0">
                                    <a href="#"><img src="{{asset('images/brands/li.svg')}}" alt="li"></a>
                                 </li>
                              </ul>
                           </div> --}}
                                    {{-- <p class="mt-3 text-center">
                              Don’t have an account? <a href="{{route('auth.signup')}}" class="text-underline">Click here to sign up.</a>
                           </p> --}}
                                </form>
			{{--	<div class="alert alert-danger mt-2" role="alert">
                                    <p>Service Un-available on 19/01/2024 from 8:00 AM to 12:00 PM Please Do Not Sign in into the Portal.</p>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sign-bg">
                    <svg width="280" height="230" viewBox="0 0 431 398" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g opacity="0.05">
                            <rect x="-157.085" y="193.773" width="543" height="77.5714" rx="38.7857"
                                transform="rotate(-45 -157.085 193.773)" fill="#3B8AFF" />
                            <rect x="7.46875" y="358.327" width="543" height="77.5714" rx="38.7857"
                                transform="rotate(-45 7.46875 358.327)" fill="#3B8AFF" />
                            <rect x="61.9355" y="138.545" width="310.286" height="77.5714" rx="38.7857"
                                transform="rotate(45 61.9355 138.545)" fill="#3B8AFF" />
                            <rect x="62.3154" y="-190.173" width="543" height="77.5714" rx="38.7857"
                                transform="rotate(45 62.3154 -190.173)" fill="#3B8AFF" />
                        </g>
                    </svg>
                </div>
            </div>
            <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
                <img src="{{ asset('images/auth/01.png') }}" class="img-fluid gradient-main animated-scaleX"
                    alt="images">
            </div>
        </div>
    </section>
</x-guest-layout>
