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
                        <style>
                            .ribcard {
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

                            .ribcard .card__container {
                                padding: 1.5rem;
                                width: 100%;
                                height: 100%;
                                background: white;
                                border-radius: 1rem;
                                position: relative;
                            }

                            .ribcard::before {
                                position: absolute;
                                top: 2rem;
                                right: -0.5rem;
                                content: "";
                                background: #283593;
                                height: 28px;
                                width: 28px;
                                transform: rotate(45deg);
                            }

                            .ribcard::after {
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
                        <div class="row">
                            @foreach ($SorLists['SORCounts'] as $category)
                                <div class="col-md-3 col-sm-6">
                                    <div class="card ribcard" data-label="{{ $category->dept_category_name }}">
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
                                </div>
                            @endforeach
                        </div>
                        <div class="card">

                            <div class="card-header">
                                <button type="button" class="btn btn-soft-primary position-relative rounded">
                                    Pending Lists
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $SorLists['sorApproverPendingCount'] }}
                                        <span class="visually-hidden">unread messages</span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-soft-primary position-relative rounded">
                                    Approved Lists
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $SorLists['sorApprovedCount'] }}
                                        <span class="visually-hidden">unread messages</span>
                                    </span>
                                </button>
                                {{-- <button type="button" class="btn btn-soft-primary position-relative rounded">
                                    Total Targets
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $SorLists['sorTargetPage'] }}
                                        <span class="visually-hidden">unread messages</span>
                                    </span>
                                </button> --}}
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
