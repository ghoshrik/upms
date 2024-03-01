<div>
    @if ($allAddedEstimatesData != null)
        <div class="col-md-12 col-lg-12">
            <div class="card overflow-hidden">
                <div class="card-header d-flex justify-content-between flex-wrap">
                    <div class="header-title">
                        <h4 class="card-title mb-2">Added Estimates List</h4>
                    </div>
                </div>
                <div>
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
                                    <button type="button" wire:click="expCalc" class="btn btn-soft-primary"
                                        @if ($totalOnSelectedCount < 1) {{ '' }}@else {{ 'disabled' }} @endif>Calculate</button>
                                </div>
                            </div>
                        </div>
                        <div class="col col-md-6 col-lg-6 mb-2">
                            <div class="btn-group float-right" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-soft-primary" wire:click="totalOnSelected"
                                    @if ($openTotalButton) {{ '' }}@else {{ 'disabled' }} @endif
                                    {{-- //bypass && $totalOnSelectedCount!=1 --}}>{{ trans('cruds.estimate.fields.total_on_selected') }}
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
                                    <th>Unit Name</th>
                                    <th>{{ trans('cruds.estimate.fields.per_unit_cost') }}</th>
                                    <th>{{ trans('cruds.estimate.fields.cost') }}</th>
                                    <th>{{ trans('cruds.estimate.fields.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allAddedEstimatesData as $key => $addedEstimate)
                                    <tr>
                                        <td>
                                            <x-checkbox wire:key="{{ $key . 'checkbox' }}" id="checkbox"
                                                wire:model.defer="level" value="{{ $addedEstimate['array_id'] }}"
                                                wire:click="showTotalButton" />
                                        </td>
                                        <td>
                                            <div wire:key="{{ $key . 'iNo' }}" class="d-flex align-items-center">
                                                {{-- {{ chr($key + 64) }} --}}
                                                {{ $addedEstimate['array_id'] }}
                                            </div>
                                        </td>
                                        <td>
                                            {{-- {{ $addedEstimate['sor_item_number'] ?  $addedEstimate['sor_item_number'] : '---'}} --}}

                                            @if ($addedEstimate['sor_item_number'] != '' && $addedEstimate['sor_item_number'] != 0)
                                                {{ $addedEstimate['sor_item_number'] }}
                                            @elseif ($addedEstimate['estimate_no'] != 0)
                                                {{ $addedEstimate['estimate_no'] }}
                                            @elseif($addedEstimate['rate_no'] != 0)
                                                {{ $addedEstimate['rate_no'] }}
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td class="text-wrap" style="width: 40rem">
                                            @if ($addedEstimate['sor_item_number'] || $addedEstimate['rate_no'])
                                                {{ $addedEstimate['description'] }}{{ $addedEstimate['rate_type'] != '' ? ' ( ' . $addedEstimate['rate_type'] . ' ) ' : '' }}
                                            @elseif ($addedEstimate['estimate_no'])
                                                {{ getEstimateDescription($addedEstimate['estimate_no']) }}
                                                {{-- {{ $addedEstimate->SOR->sorMasterDesc }} --}}
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
                                            @if ($addedEstimate['qty'] != 0)
                                                {{ $addedEstimate['qty'] }}
                                                @if (isset($addedEstimate['qtyUpdate']))
                                                    <x-button wire:click="openQtyModal({{ $key }})"
                                                        type="button" class="btn btn-soft-primary btn-sm">
                                                        <span class="btn-inner">
                                                            <x-lucide-eye class="w-4 h-4 text-white-500" />
                                                        </span>
                                                    </x-button>
                                                @else
                                                    <x-button wire:click="openQtyModal({{ $key }})"
                                                        type="button" class="btn btn-soft-primary btn-sm">
                                                        <span class="btn-inner">
                                                            <x-lucide-plus class="w-4 h-4 text-white-500" />
                                                        </span>
                                                    </x-button>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if ($addedEstimate['unit_id'] != '' && $addedEstimate['unit_id'] != 0)
                                                {{ $addedEstimate['unit_id'] }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($addedEstimate['rate'] != 0)
                                                {{ $addedEstimate['rate'] }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $addedEstimate['total_amount'] }}
                                        </td>
                                        <td>
                                            @if ($addedEstimate['estimate_no'])
                                                <x-button wire:click="viewModal({{ $addedEstimate['estimate_no'] }})"
                                                    type="button" class="btn btn-soft-primary btn-sm">
                                                    <span class="btn-inner">
                                                        <x-lucide-eye class="w-4 h-4 text-gray-500" /> View
                                                    </span>
                                                </x-button>
                                            @endif
                                            @if ($arrayRow == $key)
                                                {{-- <x-button
                                                    wire:click="confDeleteDialog({{ $addedEstimate['array_id'] }})"
                                                    type="button" class="btn btn-soft-danger btn-sm">
                                                    <span class="btn-inner">
                                                        <x-lucide-trash-2 class="w-4 h-4 text-gray-500" /> Delete
                                                    </span>
                                                </x-button> --}}
                                                <button
                                                    onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                                    wire:click="deleteEstimate('{{ $addedEstimate['array_id'] }}')"
                                                    type="button" class="btn btn-soft-danger btn-sm">
                                                    <span class="btn-inner">
                                                        <x-lucide-trash-2 class="w-4 h-4 text-gray-500" /> Delete
                                                    </span>
                                                </button>
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
                        <div class="col-6">
                            <button type="submit" wire:click='store'
                                class="btn btn-success rounded-pill float-right">Save</button>
                            <button type="submit" wire:click='store("draft")'
                                class="btn btn-soft-primary rounded-pill float-right mr-2">Draft</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @if ($openQtyModal)
            <livewire:components.modal.rate-analysis.unit-analysis-view-modal :unit_id="$sendArrayKey" :sendArrayDesc="$sendArrayDesc" :arrayCount="$arrayCount" />
        @endif
    @endif
</div>
