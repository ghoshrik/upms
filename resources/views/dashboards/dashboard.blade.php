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

        </div>

    </div>
</x-app-layout>
