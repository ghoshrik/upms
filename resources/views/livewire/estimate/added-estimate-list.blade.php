<div>
    @if ($allAddedEstimatesData != null)
        <div class="col-md-12 col-lg-12">
            <div class="card position-sticky" style="top:90px;">
                <div class="card-header d-flex justify-content-between flex-wrap">
                    <div class="header-title">
                        <h6 class="card-title mb-2">Added Estimates List</h6>
                    </div>
                </div>
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
                                <button type="button" wire:click="expCalc"
                                    class="btn btn-soft-primary">Calculate</button>
                            </div>
                        </div>
                    </div>
                    <div class="col col-md-6 col-lg-6 mb-2">
                        <div class="btn-group float-right" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-soft-primary" wire:click="totalOnSelected"
                                @if ($openTotalButton && $totalOnSelectedCount != 1) {{ '' }}@else {{ 'disabled' }} @endif>{{ trans('cruds.estimate.fields.total_on_selected') }}
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


            <div class="card" style="position:static;">
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
                                    <tr>
                                        <td>
                                            <x-checkbox wire:key="{{ $key . 'checkbox' }}" id="checkbox"
                                                wire:model.defer="level" value="{{ $addedEstimate['array_id'] }}"
                                                wire:click="showTotalButton" />
                                        </td>
                                        <td>
                                            <div wire:key="{{ $key . 'iNo' }}" class="d-flex align-items-center">
                                                {{ chr($key + 64) }}
                                            </div>
                                        </td>
                                        <td>
                                            {{ $addedEstimate['sor_item_number'] ? getSorItemNumber($addedEstimate['sor_item_number']) : '---' }}
                                        </td>
                                        <td class="text-wrap" style="width: 40rem">
                                            @if ($addedEstimate['sor_item_number'])
                                                {{ $addedEstimate['description'] }}
                                            @elseif ($addedEstimate['arrayIndex'])
                                                @if ($addedEstimate['remarks'])
                                                    {{ $addedEstimate['arrayIndex'] . ' ( ' . $addedEstimate['remarks'] . ' ) ' }}
                                                @elseif ($addedEstimate['operation'] == 'Total')
                                                    {{ 'Total of ' . $addedEstimate['arrayIndex'] }}
                                                @else
                                                    {{ $addedEstimate['arrayIndex'] }}
                                                @endif
                                            @else
                                                {{ $addedEstimate['other_name'] }}
                                            @endif

                                        </td>
                                        <td>
                                            @if ($addedEstimate['qty'])
                                                {{ $addedEstimate['qty'] }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $addedEstimate['rate'] }}
                                        </td>
                                        <td>
                                            @if ($addedEstimate['total_amount'])
                                                {{ $addedEstimate['total_amount'] }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($arrayRow == $key)
                                                <x-button
                                                    wire:click="confDeleteDialog({{ $addedEstimate['array_id'] }})"
                                                    type="button" class="btn btn-soft-danger btn-sm">
                                                    <span class="btn-inner">
                                                        <x-lucide-trash-2 class="w-4 h-4 text-gray-500" /> Delete
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
                        <div class="col-6"><button type="submit" wire:click='store'
                                class="btn btn-success rounded-pill float-right">Save</button></div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
