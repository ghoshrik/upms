<div>
    @if ($currentEstimate != null)
        <div class="col-md-12 col-lg-12">
            <div class="card overflow-hidden">
                <div class="card-header d-flex justify-content-between flex-wrap">
                    <div class="header-title">
                        <h4 class="card-title mb-2">Modify Estimate </h4>
                    </div>
                </div>
                {{-- <div>
                    <div class="row m-2">
                        <div class="col col-md-6 col-lg-6 mb-2">
                            <div class="row">
                                <div class="input-group mb-3">
                                    <input type="text" wire:model="expression" class="form-control"
                                        placeholder="{{ trans('cruds.estimate.fields.operation') }}"
                                        aria-label="{{ trans('cruds.estimate.fields.operation') }}"
                                        aria-describedby="basic-addon1">
                                    <input type="text" wire:model="remarks" class="form-control"
                                        placeholder="{{ trans('cruds.estimate.fields.remarks') }}"
                                        aria-label="{{ trans('cruds.estimate.fields.remarks') }}"
                                        aria-describedby="basic-addon1">
                                    <button type="button" wire:click=""
                                        class="btn btn-soft-primary">Calculate</button>
                                </div>
                            </div>
                        </div>
                        <div class="col col-md-6 col-lg-6 mb-2">
                            <div class="btn-group float-right" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-soft-primary" wire:click=""
                                    >{{ trans('cruds.estimate.fields.total_on_selected') }}
                                </button>
                                <button type="button" class="btn btn-soft-info" wire:click="">
                                    <span class="btn-inner">
                                        <x-lucide-sheet class="w-4 h-4 text-gray-500" />
                                    </span>
                                    {{ trans('cruds.estimate.fields.export_word') }}</button>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="card-body p-0">
                    <div class="table-responsive mt-4">
                        <table id="basic-table" class="table table-striped mb-0" role="grid">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>{{ trans('cruds.estimate.fields.id_helper') }}</th>
                                    <th>{{ trans('cruds.estimate.fields.item_number') }}</th>
                                    <th>{{ trans('cruds.estimate.fields.description') }}</th>
                                    <th>{{ trans('cruds.estimate.fields.quantity') }}</th>
                                    <th>{{ trans('cruds.estimate.fields.per_unit_cost') }}</th>
                                    <th>{{ trans('cruds.estimate.fields.cost') }}</th>
                                    <th>{{ trans('cruds.estimate.fields.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @dd($currentEstimate) --}}
                                @foreach ($currentEstimate as $key => $addedEstimate)
                                    <tr>
                                        <td>

                                        </td>
                                        <td>
                                            <div wire:key="{{ $key . 'iNo' }}" class="d-flex align-items-center">
                                                {{ chr($addedEstimate['row_id'] + 64) }}
                                            </div>
                                        </td>
                                        <td>
                                            {{-- {{ $addedEstimate['sor_item_number'] ?  $addedEstimate['sor_item_number'] : '---'}} --}}

                                            @if ($addedEstimate['sor_item_number'])
                                                {{ getSorItemNumber($addedEstimate['sor_item_number']) }}
                                            @elseif ($addedEstimate['estimate_no'])
                                                {{ $addedEstimate['estimate_no'] }}
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td>
                                            @if ($addedEstimate['sor_item_number'])
                                            {{ getSorItemNumberDesc($addedEstimate['sor_item_number']) }}
                                            @elseif ($addedEstimate['estimate_no'])
                                                {{ getEstimateDescription($addedEstimate['estimate_no']) }}
                                                {{-- {{ $addedEstimate->SOR->sorMasterDesc }} --}}
                                            @elseif ($addedEstimate['row_index'])
                                                @if ($addedEstimate['comments'])
                                                    {{ $addedEstimate['row_index'] . ' ( ' . $addedEstimate['comments'] . ' ) ' }}
                                                @elseif ($addedEstimate['operation'] == 'Total')
                                                    {{ 'Total of ' . $addedEstimate['row_index'] }}
                                                @else
                                                    {{ $addedEstimate['row_index'] }}
                                                @endif
                                            @else
                                                {{ $addedEstimate['other_name'] }}
                                            @endif

                                        </td>
                                        <td>
                                            @if ($addedEstimate['qty']!=0)
                                                {{ $addedEstimate['qty'] }}
                                            @else
                                            @endif
                                        </td>
                                        <td>
                                            @if ($addedEstimate['rate']!=0)
                                                {{ $addedEstimate['rate'] }}
                                            @else
                                            @endif
                                        </td>
                                        <td>
                                            {{ round($addedEstimate['total_amount'],10,2) }}
                                        </td>
                                        <td>
                                            @if ($addedEstimate['estimate_no'])
                                                <x-button
                                                    wire:click="viewModal({{ $addedEstimate['estimate_no'] }})"
                                                    type="button" class="btn btn-soft-primary btn-sm">
                                                    <span class="btn-inner">
                                                        <x-lucide-eye class="w-4 h-4 text-gray-500" /> View
                                                    </span>
                                                </x-button>
                                            @endif
                                            @if ($addedEstimate['row_index'] == null && $addedEstimate['estimate_no'] == null)
                                                <x-button wire:click="editEstimate({{ $addedEstimate['row_id'] }})"
                                                    type="button" class="btn btn-soft-primary btn-sm">
                                                    <span class="btn-inner">
                                                        <x-lucide-edit class="w-4 h-4 text-gray-500" /> Edit
                                                    </span>
                                                </x-button>
                                            @endif
                                            {{-- @if ($arrayRow == $addedEstimate['row_id'])
                                                <x-button
                                                    wire:click="confDeleteDialog({{ $addedEstimate['row_id'] }})"
                                                    type="button" class="btn btn-soft-danger btn-sm">
                                                    <span class="btn-inner">
                                                        <x-lucide-trash-2 class="w-4 h-4 text-gray-500" /> Delete
                                                    </span>
                                                </x-button>
                                            @endif --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6"> <button type="button" wire:click='close'
                                class="btn btn-soft-primary rounded-pill float-left">Close</button></div>
                        <div class="col-6"><button type="submit" wire:click='store({{ $estimate_id }})'
                                class="btn btn-success rounded-pill float-right">Modify</button></div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div>
        <livewire:components.modal.estimate.edit-estimate-modal />
        <livewire:components.modal.estimate.estimate-view-modal />
    </div>
</div>
