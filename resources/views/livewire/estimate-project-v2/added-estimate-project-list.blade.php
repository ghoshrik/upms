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
                {{-- <div>
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
                </div> --}}
                <div class="p-0 card-body">
                    <div class="mt-4 table-responsive">
                        <table id="basic-table" class="table mb-0 table-striped" role="grid">
                            <thead>
                                <tr>
                                    {{-- <th><x-checkbox wire:key="checkbox" id="checkbox" wire:model="selectCheckBoxs"
                                            wire:click="selectAll" title="Select All" /></th> --}}
                                    {{-- <th>{{ trans('cruds.estimate.fields.id_helper') }}</th> --}}
                                    <th>Sl No</th>
                                    <th>{{ trans('cruds.estimate.fields.item_number') }}</th>
                                    <th style="text-align: center;">{{ trans('cruds.estimate.fields.description') }}
                                    </th>
                                    <th>{{ trans('cruds.estimate.fields.quantity') }}</th>
                                    <th>Unit Name</th>
                                    <th>{{ trans('cruds.estimate.fields.per_unit_cost') }}</th>
                                    <th>{{ trans('cruds.estimate.fields.cost') }}</th>
                                    <th style="text-align: center;">{{ trans('cruds.estimate.fields.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                 {{-- @dd($allAddedEstimatesData);     --}}
                                @foreach ($allAddedEstimatesData as $key => $addedEstimate)
                                    <tr>

                                        <td>

                                            {{ $addedEstimate['id'] }}

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
                                                @if ($addedEstimate['sor_item_number'] && $addedEstimate['item_name'] && $addedEstimate['p_id'] == 0)
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
                                                {{ $addedEstimate['description'] }}
                                                {{-- {{ getEstimateDescription($addedEstimate['estimate_no']) }} --}}
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

                                                @if ($department_id != 26)
                                                    @if (isset($addedEstimate['qtyUpdate']) && $addedEstimate['qtyUpdate'] === true)
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
                                            @if (array_key_exists('rate_det', $addedEstimate) && $addedEstimate['rate_det'] != '')
                                                {{ '( ' . $addedEstimate['rate_det'] . ' )' }}
                                            @endif

                                        </td>
                                        <td>
                                            {{ $addedEstimate['total_amount'] }}
                                        </td>
                                        <td>
                                            @if ($addedEstimate['operation'] == '' || $addedEstimate['rate_no'] != 0 || $addedEstimate['rate_no'] == '')
                                                <button wire:click="editRow('{{ $addedEstimate['array_id'] }}')"
                                                    type="button" class="btn-soft-warning btn-sm">
                                                    <x-lucide-edit class="w-4 h-4 text-gray-500" /> Edit
                                                </button>
                                            @endif
                                            @if ($addedEstimate['estimate_no'] > 0)
                                                <x-button wire:click="viewModal({{ $addedEstimate['estimate_no'] }})"
                                                    type="button" class="btn btn-soft-primary btn-sm">
                                                    <span class="btn-inner">
                                                        <x-lucide-eye class="w-4 h-4 text-gray-500" /> View
                                                    </span>
                                                </x-button>
                                            @endif
                                            @if ($addedEstimate['rate_no'] > 0)
                                                <x-button wire:click="viewRateModal({{ $addedEstimate['rate_no'] }})"
                                                    type="button" class="btn btn-soft-primary btn-sm">
                                                    <span class="btn-inner">
                                                        <x-lucide-eye class="w-4 h-4 text-gray-500" /> View
                                                    </span>
                                                </x-button>
                                            @endif
                                            @if ($addedEstimate['p_id'] === '0' || $addedEstimate['p_id'] === 0)
                                                <button wire:click="addSubItem('{{ $addedEstimate['id'] }}')"
                                                    type="button" class="btn btn-soft-primary btn-sm">
                                                    <span class="btn-inner">
                                                        <x-lucide-plus class="w-4 h-4 text-gray-500" /> Add Sub
                                                    </span>
                                                </button>
                                            @endif
                                            @if ($arrayRow != $key)
                                            {{-- <x-button
                                                    wire:click="confDeleteDialog({{ $addedEstimate['array_id'] }})"
                                                    type="button" class="btn btn-soft-danger btn-sm">
                                                    <span class="btn-inner">
                                                        <x-lucide-trash-2 class="w-4 h-4 text-gray-500" /> Delete
                                                    </span>
                                                </x-button> --}}
                                            <button
                                                onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                                wire:click="deleteEstimate('{{ $addedEstimate['id'] }}')"
                                                type="button" class="btn btn-soft-danger btn-sm">
                                                <span class="btn-inner">
                                                    <x-lucide-trash-2 class="w-4 h-4 text-gray-500" /> Delete
                                                </span>
                                            </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><strong>Total</strong></td>
                                    <td><strong>{{ $autoTotalValue }}</strong></td>
                                    <td></td>
                                </tr>
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

            {{-- @dd($sendRowNo);   --}}
            @if (isset($identifier))
                <livewire:components.modal.rate-analysis.unit-analysis-view-modal :unit_id="$sendArrayKey" :sendArrayDesc="$sendArrayDesc"
                    :arrayCount="$arrayCount" :editEstimate_id="$editEstimate_id" :part_no="$part_no" :identifier='$identifier' :sendRowNo='$sendRowNo' />
            @else
                <livewire:components.modal.rate-analysis.unit-analysis-view-modal :unit_id="$sendArrayKey" :sendArrayDesc="$sendArrayDesc"
                    :arrayCount="$arrayCount" :editEstimate_id="$editEstimate_id" :part_no="$part_no" :sendRowNo='$sendRowNo' />
            @endif
        @endif

        @if ($editRowModal)
            <livewire:components.modal.item-modal.edit-row-wise :editRowId='$editRowId' :editRowData='$editRowData' :editEstimate_id='$editEstimate_id'
                :identifier='$identifier' />
        @endif
        @if ($openSubItemModal)
            <livewire:components.modal.item-modal.add-sub-item-modal :rowParentId="$rowParentId" :editEstimate_id="$editEstimate_id">
        @endif
    @endif
</div>
