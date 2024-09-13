<div>
    <div wire:loading.delay.longest>
        <div class="spinner-border text-primary loader-position" role="status"></div>
    </div>
    @if ($allAddedEstimatesData != null)
        <div wire:loading.delay.longest.class="loading" class="col-md-12 col-lg-12">
            <div class="overflow-hidden card">
                <div class="flex-wrap card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="mb-2 card-title">Added Estimates List</h4>
                    </div>
                </div>
                <div>
                    <div class="m-2 row">
                        <div class="mb-2 col col-md-6 col-lg-6">
                            <div class="row">
                                <div class="mb-3 input-group">
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
                        <div class="mb-2 col col-md-6 col-lg-6">
                            <div class="float-right btn-group" role="group" aria-label="Basic example">
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
                <div class="p-0 card-body">
                    <div class="mt-4 table-responsive">
                        <table id="basic-table" class="table mb-0 table-striped" role="grid">
                            <thead>
                                <tr>
                                    <th><x-checkbox wire:key="checkbox" id="checkbox" wire:model="selectCheckBoxs"
                                            wire:click="selectAll" title="Select All" /></th>
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
                                {{-- @dd($allAddedEstimatesData); --}}
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
                                                {{ $addedEstimate['estimate_no'] }}{{ ' ( ' . $addedEstimate['item_name'] . ' )' }}
                                            @elseif($addedEstimate['rate_no'] != 0)
                                                {{ $addedEstimate['rate_no'] }}{{ ' ( ' . $addedEstimate['item_name'] . ' )' }}
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td class="text-wrap">
                                            @if ($addedEstimate['sor_item_number'])
                                                @if ($addedEstimate['sor_item_number'] && $addedEstimate['item_name'])
                                                    <strong>{{ getDepartmentName($addedEstimate['dept_id']) . ' / ' . getDepartmentCategoryName($addedEstimate['category_id']) . ' / ' . getSorTableName($addedEstimate['sor_id']) . ' / Page No: ' . getSorPageNo($addedEstimate['sor_id']) . (getSorCorrigenda($addedEstimate['sor_id']) != null ? ' - ' . getSorCorrigenda($addedEstimate['sor_id']) : '') }}</strong>
                                                    <br />
                                                @endif
                                                {{ $addedEstimate['description'] }}
                                            @elseif ($addedEstimate['rate_no'])
                                                @php
                                                    $getRateDet = getRateDescription(
                                                        $addedEstimate['rate_no'],
                                                        $addedEstimate['rate'],
                                                    );
                                                @endphp
                                                {{ $getRateDet['description'] }}{{ $getRateDet['operation'] != '' ? ' ( ' . $getRateDet['operation'] . ' )' : '' }}
                                                {{-- {{ getRateDescription($addedEstimate['rate_no'], $addedEstimate['rate']) }}{{ $addedEstimate['rate_type'] != '' ? ' ( ' . $addedEstimate['rate_type'] . ' ) ' : '' }} --}}
                                            @elseif ($addedEstimate['estimate_no'])
                                                {{ getEstimateDescription($addedEstimate['estimate_no']) }}
                                                {{-- {{ $addedEstimate->SOR->sorMasterDesc }} --}}
                                            @elseif ($addedEstimate['arrayIndex'])
                                                @if ($addedEstimate['remarks'])
                                                    {{ str_replace('+', ' + ', $addedEstimate['arrayIndex']) . ' ( ' . $addedEstimate['remarks'] . ' ) ' }}
                                                @elseif ($addedEstimate['operation'] == 'Total')
                                                    {{ 'Total of ( ' . str_replace('+', ' + ', $addedEstimate['arrayIndex']) . ' )' }}
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
                                                @if (isset($addedEstimate['qtyUpdate']) && $addedEstimate['qtyUpdate'] == true)
                                                    {{-- @dd($addedEstimate['qtyUpdate']); --}}
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
                                            @if ($addedEstimate['operation'] == '')
                                            <button wire:click="editRow('{{ $addedEstimate['array_id'] }}')"
                                                type="button" class="btn-soft-warning btn-sm">
                                                <x-lucide-edit class="w-4 h-4 text-gray-500" /> Edit
                                            </button>
                                            @endif

                                            <!-- Confirm Modal -->
                                            {{-- <div class="modal fade" id="confirmModal" tabindex="-1"
                                                aria-labelledby="confirmModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="confirmModalLabel">Confirm Edit
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to proceed with existing quantity?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" wire:click="editRow('{{ $addedEstimate['array_id'] }}',2)" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                                <button type="button" wire:click="editRow('{{ $addedEstimate['array_id'] }}', 1)" class="btn btn-primary" id="confirmYesButton">Yes</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}
                                            {{-- @if ($addedEstimate['estimate_no'])
                                                <x-button wire:click="viewModal({{ $addedEstimate['estimate_no'] }})"
                                                    type="button" class="btn btn-soft-primary btn-sm">
                                                    <span class="btn-inner">
                                                        <x-lucide-eye class="w-4 h-4 text-gray-500" /> View
                                                    </span>
                                                </x-button>
                                            @endif --}}
                                            <x-button wire:click="viewModal({{ $addedEstimate['estimate_no'] }})"
                                                type="button" class="btn btn-soft-primary btn-sm"
                                                style="{{ $addedEstimate['estimate_no'] == 0 ? 'display:none;' : '' }}">
                                                <span class="btn-inner">
                                                    <x-lucide-eye class="w-4 h-4 text-gray-500" /> View
                                                </span>
                                            </x-button>
                                            <x-button wire:click="viewRateModal({{ $addedEstimate['rate_no'] }})"
                                                type="button" class="btn btn-soft-primary btn-sm"
                                                style="{{ $addedEstimate['rate_no'] == 0 ? 'display:none;' : '' }}">
                                                <span class="btn-inner">
                                                    <x-lucide-eye class="w-4 h-4 text-gray-500" /> View
                                                </span>
                                            </x-button>

                                            {{-- @if ($arrayRow == $key) --}}
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
                                            {{-- @endif --}}
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
                                class="float-left btn btn-soft-danger rounded-pill">Reset</button></div>
                        <div class="col-6">
                            <button type="submit" wire:click='store'
                                class="float-right btn btn-success rounded-pill">Save</button>
                            <button type="submit" wire:click='store("draft")'
                                class="float-right mr-2 btn btn-soft-primary rounded-pill">Draft</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @if ($openQtyModal)
            <livewire:components.modal.rate-analysis.unit-analysis-view-modal :unit_id="$sendArrayKey" :sendArrayDesc="$sendArrayDesc"
                :arrayCount="$arrayCount" :editEstimate_id="$editEstimate_id" :part_no="$part_no" />
        @endif
    @endif
    @if ($editRowModal)
        <livewire:components.modal.item-modal.edit-row-wise :editRowId='$editRowId' :editRowData='$editRowData' :editEstimate_id='$editEstimate_id' />
    @endif
</div>
</div>
