<div>
    <div class="conatiner-fluid content-inner py-0 mt-5">
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
                    @canany(['create dynamic-sor'])
                        <div class="d-flex justify-content-between align-items-center rounded flex-wrap gap-3">
                            @if (!$isFromOpen)
                                <button wire:click="fromEntryControl('create')" class="btn btn-primary rounded-pill "
                                    x-transition:enter.duration.600ms x-transition:leave.duration.10ms>
                                    <span class="btn-inner">
                                        <x-lucide-plus class="w-4 h-4 text-gray-500" /> Create
                                    </span>
                                </button>
                            @else
                                <button wire:click="fromEntryControl()" class="btn btn-danger rounded-pill "
                                    x-transition:enter.duration.100ms x-transition:leave.duration.100ms>
                                    <span class="btn-inner">
                                        <x-lucide-x class="w-4 h-4 text-gray-500" /> Close
                                    </span>
                                </button>
                            @endif
                        </div>
                    @endcanany
                </div>
            </div>
        </div>
        <div wire:loading.delay.long>
            <div class="spinner-border text-primary loader-position" role="status"></div>
        </div>
        <div wire:loading.delay.long.class="loading">
            <div x-transition.duration.900ms>

                @if ($isFromOpen && $openedFormType == 'create')
                    <livewire:sor-book.create-dynamic-sor-header />
                @elseif($isFromOpen && $openedFormType == 'view')
                    <livewire:sor-book.create-dynamic-sor :selectedIdForEdit="$selectedIdForEdit" />
                @else
                    <div class="col-md-12 col-lg-12 col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <livewire:sor-book.data-table.volume-one-sor-table :canPermission="$canPermission"
                                    :wire:key="$updateDataTableTracker" />
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:load', function() {
            window.addEventListener('sorDelete', event => {

                // var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'));
                // var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                //     return new bootstrap.Tooltip(tooltipTriggerEl);
                // });
                //alert('Name updated to: ' + event.detail.deleteID);
                //$('#deleteModal').modal('show');

                event.stopImmediatePropagation();
                const modal = document.getElementById('deleteModal');
                const modelcontent = modal.querySelector('.modal-body');
                modelcontent.innerHTML = '<p>Do you Want to Delete this Records ?</p>';
                const btnModalAction = modal.querySelector('#btnModalAction');
                btnModalAction.closest('.modal').querySelector('.modal-footer');
                btnModalAction.classList.add('rounded', 'btn-sm');
                let btnCancel = btnModalAction.closest('.modal').querySelector('#model-cancel');
                btnCancel.classList.add('rounded', 'btn-sm');
                $('#deleteModal').modal('show');

                btnModalAction.addEventListener('click', async function() {
                    btnModalAction.disabled = true;

                    modal.querySelector('#model-cancel').disabled = true;
                    const apiUrl = "{{ route('admin.sor-delete') }}";
                    const params = {
                        id: event.detail.deleteID
                    };
                    const urlWithParams = new URL(apiUrl);
                    urlWithParams.search = new URLSearchParams(params).toString();
                    await fetch(urlWithParams, {
                            method: "GET",
                            headers: {
                                'Content-Type': 'application/json',
                                Accept: 'application.json',
                            },
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            //console.log(data.message);
                            if (data.status === true) {
                                $('#deleteModal').modal('hide');
                                window.$wireui.notify({
                                    description: data.message,
                                    icon: 'success'
                                });
                                //window.location.reload(true);
                            } else {
                                $('#deleteModal').modal('hide');
                                window.$wireui.notify({
                                    description: data.message,
                                    icon: 'error'
                                });

                                //window.location.reload(true);
                            }
                        })

                        .catch(error => {
                            console.log('Fetch Error', error);
                        });
                });



                btnCancel.addEventListener('click', function() {
                    btnCancel.style.display = "inline-block";
                    $('#deleteModal').modal('hide');
                })
            })
        });
    </script>
</div>
