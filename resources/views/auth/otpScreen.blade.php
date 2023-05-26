<x-guest-layout>
    <section class="login-content">
        <div class="row m-0 align-items-center bg-white vh-100">
            <div class="col-md-6 p-0">
                <div class="card card-transparent auth-card shadow-none d-flex justify-content-center mb-0">
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
                            </svg>
                            <h4 class="logo-title ms-3">{{ env('APP_NAME') }}</h4> --}}
                            <img src="{{ asset('images/logo/wb_logo.png') }}" alt="logo">
                            <h4 class="logo-title ms-3">Govt. West Bengal <br><span>UPMS</span></h4>
                        </a>
                        {{-- <img src="{{ asset('images/avatars/01.png') }}" class="rounded avatar-80 mb-3" alt=""> --}}
                        <h2 class="mb-2">Hi ! {{ $userdtls->emp_name }}</h2>
                        <style>
                            /* :where(.otp-container, form, .input-field) {
                                display: flex;
                                flex-direction: column;
                                align-items: center;
                                justify-content: center;
                            } */

                            .otp-container {
                                /* padding: 20px 50px;
                                border-radius: 12px;
                                row-gap: 50px; */
                                /* box-shadow: 0 5px 10px rgba(0, 0, 0, 1.0); */
                            }

                            .otp-container h4 {
                                font-size: 1.25rem;
                                color: #333;
                                font-weight: 500;
                            }

                            .inputfield {
                                width: 100%;
                                display: flex;
                                justify-content: space-around;
                            }

                            .input {
                                height: 3em;
                                width: 3em;
                                border: 2px solid #dad9df;
                                outline: none;
                                text-align: center;
                                font-size: 1.5em;
                                border-radius: 0.3em;
                                background-color: #ffffff;
                                outline: none;
                                /*Hide number field arrows*/
                                -moz-appearance: textfield;
                            }

                            input[type="number"]::-webkit-outer-spin-button,
                            input[type="number"]::-webkit-inner-spin-button {
                                -webkit-appearance: none;
                                margin: 0;
                            }

                            .input:disabled {
                                color: #89888b;
                            }

                            .input:focus {
                                border: 3px solid #857f71;
                            }

                            #submit {
                                /* background-color: #044ecf; */
                                /* border: none; */
                                outline: none;
                                font-size: 1.2em;
                                padding: 0.8em 2em;
                                /* color: #ffffff; */
                                border-radius: 0.1em;
                                margin: 1em auto 0 auto;
                                cursor: pointer;
                            }

                            .show {
                                display: block;
                            }

                            .hide {
                                display: none;
                            }
                        </style>
                        {{-- <p>Enter your password to access the admin.</p> --}}
                        {{-- <p class="text-danger" id="countdown"></p> --}}
                        <x-auth-session-status class="mb-4" id="status" :status="session('status')" />

                        {{-- <x-auth-validation-errors class="mb-4" id="error" :errors="$errors" /> --}}
                        <div class="alert alert-danger d-none" role="alert"></div>
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert"> {{ session('error') }}
                            </div>
                        @endif


                        {{-- <div class="otp-container">
                            <h4>Enter OTP Code</h4>

                        </div> --}}
                        <form id="otpscreen">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="floating-label form-group">
                                        <input type="hidden" id="user_id"
                                            value="{{ Crypt::encryptString($user_id) }}" />
                                        <div class="inputfield">
                                            <input type="number" maxlength="1" id="input1" class="input"
                                                disabled />
                                            <input type="number" maxlength="1" id="input2" class="input"
                                                disabled />
                                            <input type="number" maxlength="1" id="input3" class="input"
                                                disabled />
                                            <input type="number" maxlength="1" id="input4" class="input"
                                                disabled />
                                            <input type="number" maxlength="1" id="input5" class="input"
                                                disabled />
                                            <input type="number" maxlength="1" id="input6" class="input"
                                                disabled />
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="fw-normal text-muted mt-2" id="resend">
                                        Didn’t get the code ? <a
                                            href="{{ url('/resend-otp/' . Crypt::encryptString($user_id)) }}"
                                            class="text-primary fw-bold text-decoration-none">Resend</a>

                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <p class="text-danger" id="countdown"></p>
                                </div>
                            </div>
                            <button type="button" id="submit" class="btn btn-primary hide">Verify OTP</button>
                        </form>
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
        var countdown = 119; // seconds
        // var timer = setInterval(function() {
        //     countdown--;
        //     document.getElementById("countdown").innerHTML = "0:" + (seconds < 10 ? "0" : "") + String(countdown);

        //     if (countdown <= 0) {
        //         clearInterval(timer);
        //         // window.location.href = "{{ route('auth.signin') }}"; // replace with your main page URL
        //     }

        // }, 1000);

        const resend = document.getElementById("resend");
        const submitButton = document.getElementById("submit");
        const status = document.getElementById("status");
        $(resend).addClass("hide");

        var countdown = 120; // seconds
        var timer = setInterval(function() {
            let minutes = Math.floor(countdown / 60);
            let seconds = (countdown % 60);
            $('#countdown').css("font-size", "25px");
            document.getElementById("countdown").innerHTML = minutes + ":" + (seconds < 10 ? "0" : "") +
                seconds;
            countdown--;
            if (countdown <= 0) {
                clearInterval(timer);
                // window.location.href = "{{ route('auth.signin') }}"; // replace with your main page URL
                document.getElementById("countdown").innerHTML = "OTP expired";
                $(".alert-danger").addClass('d-none');
                $(resend).removeClass("hide");
                $(resend).addClass("show");
                $(resend).removeClass("show");
                $(submitButton).addClass("hide");
                $(status).addClass('hide');
            }
            // else {
            //     $(submitButton).addClass("hide");
            //     $(".alert-danger").removeClass('d-none');
            //     $(".alert-danger").addClass('d-block');
            //     $(".alert-danger").html("Your otp is Expired");
            // }
        }, 1000);



        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#submit').on('click', function(e) {
            e.preventDefault();
            var input1 = $('#input1').val();
            var input2 = $('#input2').val();
            var input3 = $('#input3').val();
            var input4 = $('#input4').val();
            var input5 = $('#input5').val();
            var input6 = $('#input6').val();
            var userId = $('#user_id').val();
            const otpnum = input1 + input2 + input3 + input4 + input5 + input6;
            // console.log(otpnum, userId);
            $.ajax({
                url: "{{ route('otp.login') }}",
                data: {
                    otpnum: otpnum,
                    userId: userId,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                type: 'post',
                success: function(data) {
                    // console.log(data);

                    //enter otp and send otp correct
                    if (data.success == true) {
                        $('.alert-danger').addClass('d-none');
                        $('#status').html(data.status);
                        window.location.href = "{{ route('dashboard') }}";
                    }
                    //enter otp incorrect
                    else if ((data.error == false) || (data.success == false)) {
                        $('.alert-danger').removeClass('d-none');
                        $('.alert-danger').addClass('d-block');
                        $('.alert-danger').html(data.message);
                        $(submitButton).removeClass("show");
                        $(submitButton).addClass("hide");
                        // window.location.href = "{{ route('auth.signin') }}";
                    } else {
                        console.log("error return");
                    }
                }
            });
        });
    });
    //Initial references
    const input = document.querySelectorAll(".input");
    const inputField = document.querySelector(".inputfield");
    const submitButton = document.getElementById("submit");
    let inputCount = 0,
        finalInput = "";

    //Update input
    const updateInputConfig = (element, disabledStatus) => {
        element.disabled = disabledStatus;
        if (!disabledStatus) {
            element.focus();
        } else {
            element.blur();
        }
    };

    input.forEach((element) => {
        element.addEventListener("keyup", (e) => {
            e.target.value = e.target.value.replace(/[^0-9]/g, "");
            let {
                value
            } = e.target;

            if (value.length == 1) {
                updateInputConfig(e.target, true);

                if (inputCount <= 5 && e.key != "Backspace") {
                    finalInput += value;
                    if (inputCount < 5) {
                        updateInputConfig(e.target.nextElementSibling, false);
                    }
                }
                inputCount += 1;
            } else if (value.length == 0 && e.key == "Backspace") {
                finalInput = finalInput.substring(0, finalInput.length - 1);
                if (inputCount == 0) {
                    updateInputConfig(e.target, false);
                    return false;
                }
                updateInputConfig(e.target, true);
                e.target.previousElementSibling.value = "";
                updateInputConfig(e.target.previousElementSibling, false);
                inputCount -= 1;
            } else if (value.length > 1) {
                e.target.value = value.split("")[0];
            }
            submitButton.classList.add("hide");
        });

    });

    window.addEventListener("keyup", (e) => {
        if (inputCount > 5) {
            submitButton.classList.remove("hide");
            submitButton.classList.add("show");
            if (e.key == "Backspace") {
                finalInput = finalInput.substring(0, finalInput.length - 1);
                updateInputConfig(inputField.lastElementChild, false);
                inputField.lastElementChild.value = "";
                inputCount -= 1;
                submitButton.classList.add("hide");
            }
        }
    });

    // const validateOTP = () => {
    //     alert("Success");
    // };

    //Start
    const startInput = () => {
        inputCount = 0;
        finalInput = "";
        input.forEach((element) => {
            element.value = "";
        });
        updateInputConfig(inputField.firstElementChild, false);
    };

    window.onload = startInput();
</script>
