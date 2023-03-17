
<x-app-layout :assets="$assets ?? []">
    <div class="conatiner-fluid content-inner py-0">
        <div class="iq-navbar-header" style="height: 124px;">
            <div class="container-fluid iq-container">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 gap-3">
                    <div class="d-flex flex-column">
                        <h1 class="text-dark">{{$titel ?? 'DashBoard'}}</h1>
                        {{-- <p class="text-primary mb-0">{{$subTitel}}</p> --}}
                    </div>
                </div>
            </div>
            {{-- <div class="iq-header-img">
                <img src="{{ asset('images/dashboard/top-header.png') }}" alt="header"
                    class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
                <img src="{{ asset('images/dashboard/top-header1.png') }}" alt="header"
                    class="theme-color-purple-img img-fluid w-100 h-100 animated-scaleX">
                <img src="{{ asset('images/dashboard/top-header2.png') }}" alt="header"
                    class="theme-color-blue-img img-fluid w-100 h-100 animated-scaleX">
                <img src="{{ asset('images/dashboard/top-header3.png') }}" alt="header"
                    class="theme-color-green-img img-fluid w-100 h-100 animated-scaleX">
                <img src="{{ asset('images/dashboard/top-header4.png') }}" alt="header"
                    class="theme-color-yellow-img img-fluid w-100 h-100 animated-scaleX">
                <img src="{{ asset('images/dashboard/top-header5.png') }}" alt="header"
                    class="theme-color-pink-img img-fluid w-100 h-100 animated-scaleX">
            </div> --}}
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="row row-cols-1">
                <div class="d-slider1 overflow-hidden ">
                    {{-- <div class="row">
                        <div class="col-md-4">
                            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
                                <div class="card-body ">
                                    <div class="progress-widget">
                                        <div id="circle-progress-01"
                                            class="circle-progress-01 circle-progress circle-progress-primary text-center"
                                            data-min-value="0" data-max-value="100" data-value="90" data-type="percent">
                                            <svg class="card-slie-arrow " width="24" height="24px"
                                                viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M5,17.59L15.59,7H9V5H19V15H17V8.41L6.41,19L5,17.59Z" />
                                            </svg>
                                        </div>
                                        <div class="progress-detail">
                                            <p class="mb-2">Total Sales</p>
                                            <h4 class="counter" style="visibility: visible;">$560K</h4>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </div>
                        <div class="col-md-4">
                            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="800">
                                <div class="card-body">
                                    <div class="progress-widget">
                                        <div id="circle-progress-02"
                                            class="circle-progress-01 circle-progress circle-progress-info text-center"
                                            data-min-value="0" data-max-value="100" data-value="80" data-type="percent">
                                            <svg class="card-slie-arrow " width="24" height="24"
                                                viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M19,6.41L17.59,5L7,15.59V9H5V19H15V17H8.41L19,6.41Z" />
                                            </svg>
                                        </div>
                                        <div class="progress-detail">
                                            <p class="mb-2">Total Profit</p>
                                            <h4 class="counter">$185K</h4>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </div>
                        <div class="col-md-4">
                            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="900">
                                <div class="card-body">
                                    <div class="progress-widget">
                                        <div id="circle-progress-03"
                                            class="circle-progress-01 circle-progress circle-progress-primary text-center"
                                            data-min-value="0" data-max-value="100" data-value="70" data-type="percent">
                                            <svg class="card-slie-arrow " width="24" viewBox="0 0 24 24">
                                                <path fill="currentColor"
                                                    d="M19,6.41L17.59,5L7,15.59V9H5V19H15V17H8.41L19,6.41Z" />
                                            </svg>
                                        </div>
                                        <div class="progress-detail">
                                            <p class="mb-2">Total Cost</p>
                                            <h4 class="counter">$375K</h4>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </div> --}}
                        {{-- <div class="col-md-12 col-lg-12 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <strong> {{__('Office Admin')}}</strong>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
