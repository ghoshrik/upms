@if (session()->has('serverError'))
        <div class="col-span-12 mt-6 -mb-6 intro-y">
            <div class="alert alert-dismissible show box bg-danger text-white flex items-center mb-6" role="alert">
                <span>{{ session('serverError') }}</span>
                <button type="button" class="btn-close text-white" data-tw-dismiss="alert" aria-label="Close">
                    <x-lucide-x class="w-4 h-4 text-gray-500" />
                </button>
            </div>
        </div>
@endif
