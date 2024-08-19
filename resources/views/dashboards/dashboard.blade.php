<x-app-layout :assets="$assets ?? []">
    <div class="conatiner-fluid content-inner py-0 ">
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
                    padding: 3px 15px;
                    box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.25);
                    position: relative;
                    border-left: 1px dotted #000000;
                    border-top: 1px dotted #000000;
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

                .card {
                    border-left: 2px solid #007BFF;
                    position: relative;
                }

                .ribbon {
                    position: relative;
                    padding: 0 0.5em;
                    font-size: 1.295em;
                    margin: 0 0 0 -0.625em;
                    line-height: 1.875em;
                    /* color: #e6e2c8; */
                    border-radius: 0 0.156em 0.156em 0;
                    background: rgb(123, 159, 199);
                    box-shadow: -1px 2px 3px rgba(0, 0, 0, 0.5);
                }

                .ribbon:before,
                .ribbon:after {
                    position: absolute;
                    content: '';
                    display: block;
                }

                .ribbon:before {
                    width: 0.469em;
                    height: 100%;
                    padding: 0 0 0.438em;
                    top: 0;
                    left: -0.469em;
                    background: inherit;
                    border-radius: 0.313em 0 0 0.313em;
                }

                .ribbon:after {
                    width: 0.313em;
                    height: 0.313em;
                    background: rgba(0, 0, 0, 0.35);
                    bottom: -0.313em;
                    left: -0.313em;
                    border-radius: 0.313em 0 0 0.313em;
                    box-shadow: inset -1px 2px 2px rgba(0, 0, 0, 0.3);
                }

                * {
                    color: #000000;
                }

                .card .card__container {
                    padding: 1.5rem;
                    width: 100%;
                    height: 100%;
                    background: white;
                    border-radius: 1rem;
                    position: relative;
                }

                .card::before {
                    position: absolute;
                    top: 2rem;
                    right: -0.5rem;
                    content: "";
                    background: #283593;
                    height: 28px;
                    width: 28px;
                    transform: rotate(45deg);
                }

                .card::after {
                    position: absolute;
                    content: attr(data-label);
                    top: 11px;
                    right: -14px;
                    padding: 0.5rem;
                    /* width: 10rem; */
                    background: #3A57E8;
                    color: white;
                    text-align: center;
                    font-family: "Roboto", sans-serif;
                    box-shadow: 4px 4px 15px rgba(26, 35, 126, 0.2);
                }
            </style>

            @if (Auth::user()->hasRole('Department Admin'))
                <div class="row">
                    @foreach ($deptSorCategory as $category)
                        <div class="col-md-3 col-sm-6">
                            <div class="card" data-label="{{ $category->dept_category_name }}">
                                <div class="card__container">
                                    <div class="card-body">
                                        <strong> Schedule of Rate </strong>Target Pages :
                                        {{ $category->target_pages }} </br>Total Pages Entired :
                                        {{ $category->category_count }} </br>

                                        <strong> Corrigenda & Addendam </strong>Pages Entired :
                                        {{ $category->corrigenda_count }} </br>

                                        <strong> Total Approved :</strong>
                                        {{ $category->pending_approval_count }} </br>

                                        <strong> Total Verified :</strong>
                                        {{ $category->verified_count }} </br>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="counter">
                        <div class="counter-content">
                            <span class="counter-value"> <strong> Schedule of Rate </strong>Target Pages :
                                {{ $category->target_pages }} ,Complete
                                {{ $category->category_count }} </br>

                                <strong> Corrigenda & Addendam </strong>Complete
                                {{ $category->corrigenda_count }} </br>

                                <strong> Total Approved </strong>
                                {{ $category->pending_approval_count }} </br>

                                <strong> Total Verified </strong>
                                {{ $category->verified_count }} </br>
                            </span>
                        </div>
                    </div> --}}
                        </div>
                    @endforeach


                    {{-- @foreach ($deptSorCategory as $category)
                <div class="col-md-3 col-sm-6">
                    <div class="counter">
                        <div class="counter-content">
                            <div class="counter-icon">
                                <i class="fa fa-globe"></i>
                            </div>
                            <h3>{{ $category->dept_category_name }}</h3>
                            <h3>Schedule Of Rates :</h3>
                            <span class="counter-value"> Target Pages {{ $category->target_pages }} ,Complete
                                {{ $category->category_count }}
                            </span>
                            <h3>Corrigenda & Addenda</h3>
                            <span class="counter-value"> {{ $category->target_pages }}
                                {{ $category->category_count }}
                            </span>
                            <h3>Schedule Of Rates</h3>
                            <h3>Schedule Of Rates</h3>
                            <h3>Schedule Of Rates</h3>
                        </div>
                    </div>
                </div>
            @endforeach
            <h3>Corrigenda & Addenda</h3> --}}
                    {{-- @foreach ($deptSorCorrigendaCategory as $corrigenda)
                <div class="col-md-3 col-sm-6">
                    <div class="counter">
                        <div class="counter-content">
                            <div class="counter-icon">
                                <i class="fa fa-globe"></i>
                            </div>
                            <h3>{{ $corrigenda->dept_category_name }}</h3>
                            <h3>Corrigenda & Addenda</h3>
                            <span class="counter-value"> {{ $corrigenda->category_count }} Pages </span>
                        </div>
                    </div>
                </div>
            @endforeach --}}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
