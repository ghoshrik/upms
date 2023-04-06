<x-guest-layout>
    <section class="login-content">
        <div class="row m-0 align-items-center bg-white vh-100">
            <div class="col-md-6 p-0">
                <div class="card card-transparent auth-card shadow-none d-flex justify-content-center mb-0">
                    <div class="card-body">
                        <a href="{{ route('dashboard') }}" class="navbar-brand d-flex align-items-center mb-3">
                            <svg width="30" class="text-primary" viewBox="0 0 30 30" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect x="-0.757324" y="19.2427" width="28" height="4" rx="2"
                                    transform="rotate(-45 -0.757324 19.2427)" fill="currentColor" />
                                <rect x="7.72803" y="27.728" width="28" height="4" rx="2"
                                    transform="rotate(-45 7.72803 27.728)" fill="currentColor" />
                                <rect x="10.5366" y="16.3945" width="16" height="4" rx="2"
                                    transform="rotate(45 10.5366 16.3945)" fill="currentColor" />
                                <rect x="10.5562" y="-0.556152" width="28" height="4" rx="2"
                                    transform="rotate(45 10.5562 -0.556152)" fill="currentColor" />
                            </svg>
                            <h4 class="logo-title ms-3">{{ env('APP_NAME') }}</h4>
                        </a>
                        <img src="{{ asset('images/avatars/01.png') }}" class="rounded avatar-80 mb-3" alt="">
                        <h2 class="mb-2">Hi ! {{ $userdtls->emp_name }}</h2>
                        <style>
                            :where(.otp-container, form, .input-field) {
                                display: flex;
                                flex-direction: column;
                                align-items: center;
                                /* justify-content: center; */
                            }

                            .otp-container {
                                padding: 20px 50px;
                                border-radius: 12px;
                                row-gap: 50px;
                                /* box-shadow: 0 5px 10px rgba(0, 0, 0, 1.0); */
                            }

                            .otp-container h4 {
                                font-size: 1.25rem;
                                color: #333;
                                font-weight: 500;
                            }

                            .otp-container form .input-field {
                                flex-direction: row;
                                column-gap: 25px;
                            }

                            .otp-container .input-field input {
                                height: 45px;
                                width: 60px;
                                border-radius: 6px;
                                outline: none;
                                font-size: 1.125rem;
                                text-align: center;
                                border: 1px solid #ddd;
                            }

                            .otp-container .input-field input:focus {
                                box-shadow: 0 1px 0rgba(0, 0, 0, 0.1);
                            }

                            .otp-container .input-field input::-webkit-inner-spin-button,
                            .otp-container .input-field input::-webkit-outer-spin-button {
                                display: none;
                            }

                            .otp-container form button {
                                margin-top: 25px;
                                width: 100%;
                                font-size: 1rem;
                                color: #ffffff;
                                border: none;
                                padding: 9px 0;
                                cursor: pointer;
                                border-radius: 6px;
                                pointer-events: none;
                                background: #6e93f7;
                                transition: all 0.2s ease;
                            }

                            .otp-container form button.active {
                                background: #34070f4;
                                pointer-events: auto;
                            }

                            .otp-container form button:hover {
                                background: #0e4bf1;
                            }
                        </style>
                        {{-- <p>Enter your password to access the admin.</p> --}}
                        <p class="text-danger" id="countdown"></p>
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        {{-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> --}}
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert"> {{ session('error') }}
                            </div>
                        @endif


                        <div class="otp-container">
                            <h4>Enter OTP Code</h4>
                            <form action="{{ route('otp.login') }}" method="post">
                                @csrf
                                {{-- <div class="row">
                                <div class="col-lg-12"> --}}
                                {{-- <div class="floating-label form-group">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password"
                                            aria-describedby="password" placeholder=" ">
                                    </div> --}}
                                <input type="hidden" name="user_id" value="{{ $user_id }}" />
                                <div class="input-field">
                                    <input type="number" name="verifyOtp[]" />
                                    <input type="number" name="verifyOtp[]" maxlength="1" disabled />
                                    <input type="number" name="verifyOtp[]" maxlength="1" disabled />
                                    <input type="number" name="verifyOtp[]" maxlength="1" disabled />
                                    <input type="number" name="verifyOtp[]" maxlength="1" disabled />
                                    <input type="number" name="verifyOtp[]" maxlength="1" disabled />
                                </div>
                                {{-- <input type= --}}
                                {{-- </div>
                            </div> --}}
                                {{-- <div class="text-center mt-2"><span class="d-block mobile-text">Don't receive the
                                        code?</span><span class="font-weight-bold text-danger cursor">Resend</span>
                                </div> --}}
                                <div class="fw-normal text-muted mt-2">
                                    Didn’t get the code ? <a href="#"
                                        class="text-primary fw-bold text-decoration-none">Resend</a>
                                </div>
                                <button type="submit" class="btn btn-primary">Verify OTP</button>
                            </form>
                        </div>











                        {{-- <form action="{{ route('otp.login') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="floating-label form-group">
                                        <input type="hidden" name="user_id" value="{{ $user_id }}" />

                                        <label for="password" class="form-label">OTP</label> --}}
                        {{-- <input type="password"
                                            class="form-control @error('verifyOtp') is-invalid @enderror"
                                            name="verifyOtp" id="password" aria-describedby="password" placeholder=" ">

                                        @error('verifyOtp')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror --}}

                        {{-- <div class="input-field">
                                            <input type="number" />
                                            <input type="number" disabled />
                                            <input type="number" disabled />
                                            <input type="number" disabled />
                                            <input type="number" disabled />
                                            <input type="number" disabled />
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form> --}}
                    </div>
                </div>
                <div class="sign-bg">
                    <svg width="280" height="230" viewBox="0 0 431 398" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g opacity="0.05">
                            <rect x="-157.085" y="193.773" width="543" height="77.5714" rx="38.7857"
                                transform="rotate(-45 -157.085 193.773)" fill="#3B8AFF"></rect>
                            <rect x="7.46875" y="358.327" width="543" height="77.5714" rx="38.7857"
                                transform="rotate(-45 7.46875 358.327)" fill="#3B8AFF"></rect>
                            <rect x="61.9355" y="138.545" width="310.286" height="77.5714" rx="38.7857"
                                transform="rotate(45 61.9355 138.545)" fill="#3B8AFF"></rect>
                            <rect x="62.3154" y="-190.173" width="543" height="77.5714" rx="38.7857"
                                transform="rotate(45 62.3154 -190.173)" fill="#3B8AFF"></rect>
                        </g>
                    </svg>
                </div>
            </div>
            <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
                <img src="{{ asset('images/auth/04.png') }}" class="img-fluid gradient-main animated-scaleX"
                    alt="images">
            </div>
        </div>
    </section>
</x-guest-layout>
<script>
    $(document).ready(function() {
        //alert("hii");
        var countdown = 300; // seconds
        var timer = setInterval(function() {
            countdown--;
            document.getElementById("countdown").innerHTML = "Time remaining: " + countdown +
                " seconds";
            if (countdown <= 0) {
                clearInterval(timer);
                // window.location.href = "{{ route('auth.signin') }}"; // replace with your main page URL
            }
        }, 1000);

    });

    const inputs = document.querySelectorAll("input"),
        button = document.querySelector("button");

    // iterate over all inputs
    inputs.forEach((input, index1) => {
        input.addEventListener("keyup", (e) => {
            // This code gets the current input element and stores it in the currentInput variable
            // This code gets the next sibling element of the current input element and stores it in the nextInput variable
            // This code gets the previous sibling element of the current input element and stores it in the prevInput variable
            const currentInput = input,
                nextInput = input.nextElementSibling,
                prevInput = input.previousElementSibling;

            // if the value has more than one character then clear it
            console.log(currentInput.value.length);
            if (currentInput.value.length > 1) {
                currentInput.value = "";
                return;
            }
            // if the next input is disabled and the current value is not empty
            //  enable the next input and focus on it
            if (nextInput && nextInput.hasAttribute("disabled") && currentInput.value !== "") {
                nextInput.removeAttribute("disabled");
                nextInput.focus();
            }
            console.log(input);

            // if the backspace key is pressed
            if (e.key === "Backspace") {
                // iterate over all inputs again
                inputs.forEach((input, index2) => {
                    // if the index1 of the current input is less than or equal to the index2 of the input in the outer loop
                    // and the previous element exists, set the disabled attribute on the input and focus on the previous element
                    if (index1 <= index2 && prevInput) {
                        input.setAttribute("disabled", true);
                        input.value = "";
                        prevInput.focus();
                    }
                });
            }
            //if the fourth input( which index number is 3) is not empty and has not disable attribute then
            //add active class if not then remove the active class.
            if (!inputs[3].disabled && inputs[3].value !== "") {
                button.classList.add("active");
                return;
            }
            button.classList.remove("active");
        });
    });

    //focus the first input which index is 0 on window load
    window.addEventListener("load", () => inputs[0].focus());
</script>
