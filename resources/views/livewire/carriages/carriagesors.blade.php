<div>
    @section('webtitle')
        {{ __('Carriages Sors') }}
    @endsection
    <div class="conatiner-fluid content-inner py-0">
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
                        <h5 class="text-dark">{{ $titel }}</h5>
                        <p class="text-primary mb-0">{{ $subTitel }}</p>
                    </div>
                    @canany(['create sor', 'edit sor'])
                        <div class="d-flex justify-content-between align-items-center rounded flex-wrap gap-3">
                            @if (!$isFromOpen)
                                <button wire:click="fromEntryControl('create')" class="btn btn-primary rounded-pill"
                                    x-transition:enter.duration.600ms x-transition:leave.duration.10ms>
                                    <span class="btn-inner">
                                        <x-lucide-plus class="w-4 h-4 text-gray-500" /> Create
                                    </span>
                                </button>
                            @else
                                <button wire:click="fromEntryControl" class="btn btn-danger rounded-pill"
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
        <div x-show="formOpen">
            @if ($isFromOpen && $openedFormType == 'create')
                <livewire:carriages.create-carriage-sor/>
            @elseif($isFromOpen && $openedFormType == 'edit')
                {{-- <livewire:sor.edit-sor /> --}}
            @else
            <x-cards title="">
                <x-slot name="table">
                    <div class="table-responsive mt-4">
                        <table id="basic-table" class="table table-striped mb-0" role="grid">
                            <thead>
                                <tr>
                                    <th>{{ trans('cruds.sor.fields.id_helper') }}</th>
                                    <th> parent {{ trans('cruds.sor.fields.item_number') }}</th>
                                    <th>Child {{ trans('cruds.sor.fields.item_number') }}</th>
                                    <th>{{ trans('cruds.sor.fields.description') }}</th>
                                    <th>Distance Range</th>
                                    <th>{{ trans('cruds.sor.fields.cost') }}</th>
                                    <th>Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($CarriageSor as $lists)
                                    @php
                                        $sor_item = DB::table('s_o_r_s')->select('Item_details')->where('id',$lists->sor_parent_id)->first();
                                    @endphp
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$lists->getSORParentDetails->Item_details}}</td>
                                    <td>{{$lists->getSORChildDetails->Item_details}}</td>
                                    <td>{{$lists->description}}</td>
                                    <td>{{$lists->start_distance .' - '. $lists->upto_distance ." KM."}}</td>
                                    <td>{{$lists->cost}}</td>
                                    <td>{{$lists->total_number}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-slot>
            </x-cards>
            @endif
        </div>
    </div>
</div>
