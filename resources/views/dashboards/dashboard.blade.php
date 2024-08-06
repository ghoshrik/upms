<x-app-layout :assets="$assets ?? []">
    <div class="conatiner-fluid content-inner py-0 mt-5">
        <div class="iq-navbar-header" style="height: 124px;">
            <div class="container-fluid iq-container">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 gap-3">
                    <div class="d-flex flex-column">
                        <h1 class="text-dark">{{ $titel ?? 'DashBoard' }}</h1>
                        {{-- <p class="text-primary mb-0">{{$subTitel}}</p> --}}
                    </div>
                </div>
            </div>
            <style>
                .card {
                    border: none;
                    border-radius: 10px
                }

                .c-details span {
                    font-weight: 300;
                    font-size: 13px;
                    color: #000000;
                }

                /* .icon {
                                                                                                                                                                                                                                                                                width: 50px;
                                                                                                                                                                                                                                                                                height: 50px;
                                                                                                                                                                                                                                                                                background-color: #eee;
                                                                                                                                                                                                                                                                                border-radius: 15px;
                                                                                                                                                                                                                                                                                display: flex;
                                                                                                                                                                                                                                                                                align-items: center;
                                                                                                                                                                                                                                                                                justify-content: center;
                                                                                                                                                                                                                                                                                font-size: 39px
                                                                                                                                                                                                                                                                            } */

                .badge span {
                    background-color: #fffbec;
                    width: 60px;
                    height: 25px;
                    padding-bottom: 3px;
                    border-radius: 5px;
                    display: flex;
                    color: #5d8dfe;
                    justify-content: center;
                    align-items: center
                }

                .ag-courses-item_bg {
                    height: 111px;
                    width: 111px;
                    background-color: #3a57e8;

                    z-index: 1;
                    position: absolute;
                    top: -75px;
                    right: -75px;

                    border-radius: 50%;

                    -webkit-transition: all .5s ease;
                    -o-transition: all .5s ease;
                    transition: all .5s ease;
                }

                .ag-courses-item_link {
                    overflow: hidden;
                }

                .ag-courses-item_link:hover .ag-courses-item_bg {
                    -webkit-transform: scale(10);
                    -ms-transform: scale(10);
                    transform: scale(10);
                }

                .ag-courses-item_title {
                    min-height: 87px;
                    margin: 0 0 25px;

                    overflow: hidden;

                    font-weight: bold;
                    font-size: 30px;
                    color: #FFF;

                    z-index: 2;
                    position: relative;
                }


                .counter {
                    color: #666;
                    font-family: 'Poppins', sans-serif;
                    text-align: center;
                    /* width: 200px; */
                    height: 215px;
                    padding: 0 20px 20px 0;
                    margin: 0 auto;
                    margin-bottom: 5px;
                    position: relative;
                    z-index: 1;
                }

                .counter:before,
                .counter:after {
                    content: "";
                    background: linear-gradient(#F3AC2F, #ED6422);
                    position: absolute;
                    top: 10px;
                    left: 10px;
                    right: 0;
                    bottom: 0;
                    z-index: -1;
                }

                .counter:after {
                    background: transparent;
                    border: 2px dashed rgba(255, 255, 255, 0.5);
                    top: 20px;
                    left: 20px;
                    right: 10px;
                    bottom: 10px;
                }

                .counter .counter-content {
                    background-color: #fff;
                    height: 100%;
                    padding: 23px 15px;
                    box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.25);
                    position: relative;
                }

                .counter .counter-content:before,
                .counter .counter-content:after {
                    content: '';
                    background: linear-gradient(to top right, #ad3a05 50%, transparent 52%);
                    height: 10px;
                    width: 10px;
                    position: absolute;
                    right: -10px;
                    top: 0;
                }

                .counter .counter-content:after {
                    transform: rotate(180deg);
                    top: auto;
                    bottom: -10px;
                    right: auto;
                    left: 0;
                }

                .counter .counter-icon {
                    font-size: 35px;
                    line-height: 35px;
                    margin: 0 0 15px;
                }

                .counter h3 {
                    color: #161616;
                    font-size: 12px;
                    font-weight: 600;
                    letter-spacing: 1px;
                    line-height: 20px;
                    text-transform: uppercase;
                    margin: 0 0 7px;
                }

                .counter .counter-value {
                    font-size: 15px;
                    font-weight: 600;
                    display: block;
                }

                .counter.purple:before {
                    background: linear-gradient(#C4588C, #BE2A8D);
                }

                .counter.purple .counter-content:before,
                .counter.purple .counter-content:after {
                    background: linear-gradient(to top right, #7c1058 50%, transparent 52%);
                }

                .counter.purple h3 {
                    color: #BE2A8D;
                }

                .counter.blue:before {
                    background: linear-gradient(#7ACBC5, #2D9C91);
                }

                .counter.blue .counter-content:before,
                .counter.blue .counter-content:after {
                    background: linear-gradient(to top right, #0a5b53 50%, transparent 52%);
                }

                .counter.blue h3 {
                    color: #2D9C91;
                }

                .counter.green:before {
                    background: linear-gradient(#C0D62A, #83C040);
                }

                .counter.green .counter-content:before,
                .counter.green .counter-content:after {
                    background: linear-gradient(to top right, #518416 50%, transparent 52%);
                }

                .counter.green h3 {
                    color: #83C040;
                }

                @media screen and (max-width:990px) {
                    .counter {
                        margin-bottom: 40px;
                    }
                }
            </style>
        </div>
        <div class="row">
            <h3>Schedule Of Rates</h3>
            @foreach ($deptSorCategory as $category)
                <div class="col-md-3 col-sm-6">
                    <div class="counter">
                        <div class="counter-content">
                            <div class="counter-icon">
                                <i class="fa fa-globe"></i>
                            </div>
                            <h3>{{ $category->dept_category_name }}</h3>
                            <h3>Schedule Of Rates</h3>
                            <span class="counter-value"> {{$category->target_pages}} Pages of {{ $category->category_count }} </span>
                        </div>
                    </div>
                </div>
            @endforeach
            <h3>Corrigenda & Addenda</h3>
            @foreach ($deptSorCorrigendaCategory as $corrigenda)
                <div class="col-md-3 col-sm-6">
                    <div class="counter">
                        <div class="counter-content">
                            <div class="counter-icon">
                                <i class="fa fa-globe"></i>
                            </div>
                            <h3>{{ $corrigenda->dept_category_name }}</h3>
                            <h3>Corrigenda & Addenda</h3>
                            <span class="counter-value"> {{$corrigenda->category_count}} Pages </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
