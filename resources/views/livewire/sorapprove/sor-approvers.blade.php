<div>
    <div class="conatiner-fluid content-inner py-0 mt-3">
        <div class="iq-navbar-header" style="height: 124px;">
            @if ($errorMessage != null)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span> {{ $errorMessage }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="container-fluid iq-container">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 gap-3">
                    <div class="d-flex flex-column">
                        <h3 class="text-dark">{{ $titel }}</h3>
                        <p class="text-primary mb-0">{{ $subTitel }}</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center rounded flex-wrap gap-3">
                        @if ($isFromOpen)
                            <button wire:click="fromEntryControl()" class="btn btn-danger rounded-pill "
                                x-transition:enter.duration.100ms x-transition:leave.duration.100ms>
                                <span class="btn-inner">
                                    <x-lucide-x class="w-4 h-4 text-gray-500" /> Close
                                </span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @section('webtitle', trans('cruds.sor-approver.title_singular'))
        {{-- <div wire:loading.delay.long>
            <div class="spinner-border text-primary loader-position" role="status"></div>
        </div> --}}
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-3 col-xs-3">
                @if ($isFromOpen && $openedFormType == 'view')
                    <livewire:sor-book.create-dynamic-sor :selectedIdForEdit="$selectedIdForEdit">
                    @else
                        <div class="card">
                            <div class="card-header">
                                <button type="button" class="btn btn-soft-primary position-relative rounded">
                                    Pending Lists
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $SorLists['sorCount'] }}
                                        <span class="visually-hidden">unread messages</span>
                                    </span>
                                </button>
                            </div>
                            <div class="card-body">
                                <livewire:sorapprove.data-table.sor-approver-table
                                    :wire:key='$updateDataTableTracker' />
                            </div>
                        </div>
                @endif
            </div>
        </div>
    </div>
</div>
