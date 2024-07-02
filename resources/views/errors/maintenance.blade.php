<x-guest-layout>
    <div class="container-fluid p-0">
        <div class="iq-maintenance text-center">
            <img src="{{ asset('images/error/01.png') }}" class="img-fluid mb-4" alt="">
            <div class="maintenance-bottom text-white pb-0">
                <div class="bg-primary" style="background: transparent; height: 320px;">
                    <div class="gradient-bottom">
                        <div class="bottom-text general-zindex">
                            <h1 class="mb-2 text-white">Hang on! We are under maintenance</h1>
                            <p>It will not take a long time till we get the error fixed. We will live again in</p>
                            <ul class="countdown d-flex justify-content-center align-items-center list-inline"
                                data-date="Feb 02 2022 20:20:22" id="countdown">
                                <li>
                                    <span data-days>0</span>Days
                                </li>
                                <li>
                                    <span data-hours>0</span>Hours
                                </li>
                                <li>
                                    <span data-minutes>0</span>Minutes
                                </li>
                                <li>
                                    <span data-seconds>0</span>Seconds
                                </li>
                                <li>
                                    <span id="demo"></span>
                                </li>
                            </ul>
                            {{-- <div class="w-50 mx-auto mt-2">
                                <div class="input-group search-input search-input">
                                    <input type="text" class="form-control" placeholder="Enter your mail">
                                    <a href="#" class="btn bg-white text-primary ms-2 rounded">Notify Me</a>
                                </div>
                            </div> --}}
                        </div>
                        <div class="c xl-circle">
                            <div class="c lg-circle">
                                <div class="c md-circle">
                                    <div class="c sm-circle">
                                        <div class="c xs-circle"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sign-bg">
            <svg width="280" height="230" viewBox="0 0 431 398" fill="none" xmlns="http://www.w3.org/2000/svg">
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
</x-guest-layout>
<script>
    // $(document).ready(function() {
    var deadline = new Date("May 10, 2023 13:30:25").getTime();
    const Timer = document.getElementById("countdown").children;

    // console.log(Timer[0].children);
    var x = setInterval(function() {
        var nowDate = new Date().getTime();
        var t = deadline - nowDate;
        console.log(t);
        var days = Math.floor(t / (1000 * 60 * 60 * 24));
        var hours = Math.floor((t % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((t % (1000 * 60)) / 1000);
        // console.log();
        // console.log(Timer[0].children.innerHTML = days + " " + Timer[1].children.innerHTML = hours + " " +
        //     Timer[2].children.innerHTML = minutes + " " +
        //     Timer[3].children.innerHTML = seconds);

        Timer[0].children = days;
        Timer[1].children = hours;
        Timer[2].children = minutes;
        Timer[3].children = seconds;
        Timer[4].children.innerText = seconds
        if (t < 0) {
            clearInterval(x);
            Timer[0].children = 0;
            Timer[1].children = 0;
            Timer[2].children = 0;
            Timer[3].children = 0;
        }
    }, 1000);

    // });
</script>

{{-- <script src="{{ asset('js/countdown.js') }}"></script> --}}
