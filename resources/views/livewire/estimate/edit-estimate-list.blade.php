<div>
    @if ($allAddedEstimatesData != null)
        <div class="col-md-12 col-lg-12">
            <div class="card overflow-hidden">
                <div class="card-header d-flex justify-content-between flex-wrap">
                    <div class="header-title">
                        <h4 class="card-title mb-2">Edit Estimates List</h4>
                    </div>
                </div>
                <div>
                    <div class="row m-2">
                        <div class="col col-md-6 col-lg-6 mb-2">
                            <div class="row">
                                <div class="input-group mb-3">
                                    <input type="text" wire:model.defer="expression" class="form-control"
                                        placeholder="{{ trans('cruds.estimate.fields.operation') }}"
                                        aria-label="{{ trans('cruds.estimate.fields.operation') }}"
                                        aria-describedby="basic-addon1">
                                    <input type="text" wire:model.defer="remarks" class="form-control"
                                        placeholder="{{ trans('cruds.estimate.fields.remarks') }}"
                                        aria-label="{{ trans('cruds.estimate.fields.remarks') }}"
                                        aria-describedby="basic-addon1">
                                    <button type="button" wire:click="expCalc"
                                        class="btn btn-soft-primary">Calculate</button>
                                </div>
                            </div>
                        </div>
                        <div class="col col-md-6 col-lg-6 mb-2">
                            <div class="btn-group float-right" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-soft-primary" wire:click="totalOnSelected"
                                    @if ($openTotalButton) {{ '' }}@else {{ 'disabled' }} @endif>{{ trans('cruds.estimate.fields.total_on_selected') }}
                                </button>
                                <button type="button" class="btn btn-soft-info" wire:click="exportWord">
                                    <span class="btn-inner">
                                        <x-lucide-sheet class="w-4 h-4 text-gray-500" />
                                    </span>
                                    {{ trans('cruds.estimate.fields.export_word') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
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
                                {{-- @dd($allAddedEstimatesData) --}}
                                @foreach ($allAddedEstimatesData as $key => $addedEstimate)
                                    {{-- @dd($addedEstimate) --}}
                                    @php
                                        // $sorDesc = \App\Models\
                                    @endphp
                                    <tr>
                                        <td>
                                            <x-checkbox wire:key="{{ $key . 'checkbox' }}" id="checkbox"
                                                wire:model.defer="level" value="{{ $addedEstimate['row_id'] }}"
                                                wire:click="showTotalButton" />
                                        </td>
                                        <td>
                                            <div wire:key="{{ $key . 'iNo' }}" class="d-flex align-items-center">
                                                {{ chr($addedEstimate['row_id'] + 64) }}
                                            </div>
                                        </td>
                                        <td>
                                            @if ($addedEstimate['sor_item_number'])
                                                {{ getSorItemNumber($addedEstimate['sor_item_number']) }}
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td class="text-wrap" style="width: 40rem">
                                            @if ($addedEstimate['sor_item_number'])
                                                {{ getSorItemNumberDesc($addedEstimate['sor_item_number']) }}
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
                                            {{ $addedEstimate['qty'] }}
                                        </td>
                                        <td>
                                            {{ $addedEstimate['rate'] }}
                                        </td>
                                        <td>
                                            {{ round($addedEstimate['total_amount'],10,2) }}
                                        </td>
                                        <td>
                                            @if ($addedEstimate['row_index'] == null)
                                                {{-- <x-button wire:click="editEstimate({{ $addedEstimate['row_id'] }})"
                                                    type="button" class="btn btn-soft-primary btn-sm px-3 py-2.5 m-1 rounded">
                                                    <span class="btn-inner">
                                                        <x-lucide-edit class="w-4 h-4 text-gray-500" /> {{ trans('global.edit_btn') }}
                                                    </span>
                                                </x-button> --}}
                                                <x-edit-button wire:click="editEstimate({{ $addedEstimate['row_id'] }})" id action/>
                                            @endif
                                            @if ($arrayRow == $addedEstimate['row_id'])
                                                <x-button wire:click="confDeleteDialog({{ $addedEstimate['row_id'] }})"
                                                    type="button" class="btn btn-soft-danger btn-sm px-3 py-2.5 m-1 rounded">
                                                    <span class="btn-inner">
                                                        <x-lucide-trash-2 class="w-4 h-4 text-gray-500" /> {{ trans('global.delete_btn') }}
                                                    </span>
                                                </x-button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6"> <button type="button" wire:click='resetSession'
                                class="btn btn-soft-danger rounded-pill float-left">Reset</button></div>
                        <div class="col-6"><button type="submit" wire:click='store({{ $updateEstimate_id }})'
                                class="btn btn-success rounded-pill float-right">Save</button></div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
