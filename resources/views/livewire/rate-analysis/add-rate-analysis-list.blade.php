<div>
    {{-- @dd($editEstimate_id); --}}

    @if ($allAddedRateData != null)
        <div class="col-md-12 col-lg-12">
            <div class="overflow-hidden card">
                <div class="flex-wrap card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="mb-2 card-title">Added Rates List </h4>
                    </div>
                </div>
                <div>
                    <div class="m-2 row">
                        <div class="mb-2 col col-md-6 col-lg-6">
                            <div class="row">
                                <div class="mb-3 input-group">
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
                        <div class="mb-2 col col-md-6 col-lg-6">
                            <div class="float-right btn-group" role="group" aria-label="Basic example">
                                {{-- @if ($hideWithStackBtn == true) --}}
                                <button type="button" class="btn btn-soft-primary"
                                    wire:click="totalOnSelected('With Stacking')">With Stacking</button>
                                {{-- @endif --}}
                                {{-- @if ($hideWithoutStackBtn == true) --}}
                                <button type="button" class="btn btn-soft-primary"
                                    wire:click="totalOnSelected('Without Stacking')">Without Stacking</button>
                                {{-- @endif --}}
                                {{-- @if ($hideTotalbutton == true) --}}
                                <button type="button" class="btn btn-soft-primary"
                                    wire:click="totalOnSelected('Total')">{{ trans('cruds.estimate.fields.total_on_selected') }}
                                </button>
                                {{-- @endif --}}
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
                                    <th class="text-wrap">{{ trans('cruds.estimate.fields.id_helper') }}</th>
                                    <th>ITEM NO(RATE NO)</th>
                                    <th class="text-wrap">{{ trans('cruds.estimate.fields.description') }}</th>
                                    <th>{{ trans('cruds.estimate.fields.quantity') }}</th>
                                    <th>Unit Name</th>
                                    <th>{{ trans('cruds.estimate.fields.per_unit_cost') }}</th>
                                    <th>{{ trans('cruds.estimate.fields.cost') }}</th>
                                    <th>{{ trans('cruds.estimate.fields.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @dd($allAddedRateData)    --}}
                                @foreach ($allAddedRateData as $key => $addedRate)
                                    <tr>
                                        <td>
                                            <x-checkbox wire:key="{{ $key . 'checkbox' }}" id="checkbox"
                                                wire:model.defer="level" value="{{ $addedRate['array_id'] }}"
                                                wire:click="showTotalButton" />
                                        </td>
                                        <td>
                                            <div wire:key="{{ $key . 'iNo' }}" class="d-flex align-items-center">

                                                {{ $addedRate['array_id'] }}
                                            </div>
                                        </td>
                                        <td class="text-wrap">
                                            {{-- {{ $addedRate['sor_item_number'] ?  $addedRate['sor_item_number'] : '---'}} --}}

                                            @if ($addedRate['sor_item_number'])
                                                {{-- {{ getSorItemNumber($addedRate['sor_item_number']) }} --}}
                                                {{ $addedRate['sor_item_number'] }}
                                            @elseif ($addedRate['rate_no'])
                                                {{ $addedRate['rate_no'] }}
                                            @elseif ($addedRate['is_row'] != '' && $addedRate['is_row'] != 2)
                                                @php
                                                    // $getDynamicSorDetails = DynamicSorHeader::where('id',$addedRate['sor_itemno_child_id'])->select('table_no','page_no','corrigenda_name')->first();
                                                    $getDynamicSorDetails = DB::select(
                                                        'SELECT table_no, page_no, corrigenda_name FROM dynamic_table_header WHERE id = :id',
                                                        ['id' => $addedRate['sor_id']],
                                                    );
                                                @endphp
                                                @if (isset($getDynamicSorDetails[0]->corrigenda_name) && $getDynamicSorDetails[0]->corrigenda_name != '')
                                                    {{ $getDynamicSorDetails[0]->table_no . ' (' . $getDynamicSorDetails[0]->page_no . ') ' . $getDynamicSorDetails[0]->corrigenda_name }}
                                                @else
                                                    {{ $getDynamicSorDetails[0]->table_no . ' ' . $getDynamicSorDetails[0]->page_no }}
                                                @endif
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td class="text-wrap" /*style="width: 50rem;"* />
                                        @if (
                                            $addedRate['sor_item_number'] != 0 ||
                                                ($addedRate['is_row'] != '' && $addedRate['is_row'] == 0) ||
                                                $addedRate['is_row'] == 2)
                                            {{ $addedRate['description'] }}
                                            @if ($addedRate['operation'] != '')
                                                ({{ str_replace('+', ' + ', $addedRate['arrayIndex']) }})
                                                ({{ $addedRate['operation'] }})
                                            @endif
                                        @elseif ($addedRate['rate_no'] != 0)
                                            {{-- {{ getEstimateDescription($addedRate['rate_no']) }} --}}
                                            {{ $addedRate['description'] }}
                                            @if ($addedRate['operation'] != '')
                                                ({{ $addedRate['operation'] }})
                                            @endif
                                            {{-- {{ $addedRate->SOR->rateMasterDesc }} --}}
                                        @elseif ($addedRate['arrayIndex'] != '')
                                            @if ($addedRate['remarks'])
                                                {{ str_replace('+', ' + ', $addedRate['arrayIndex']) . ' ( ' . $addedRate['remarks'] . ' ) ' }}
                                            @elseif ($addedRate['operation'] == 'Total')
                                                {{ 'Total of ' . str_replace('+', ' + ', $addedRate['arrayIndex']) }}
                                            @else
                                                {{ str_replace('+', ' + ', $addedRate['arrayIndex']) }}
                                            @endif
                                        @else
                                            {{ $addedRate['other_name'] }}
                                        @endif
                                        </td>
                                        <td>
                                            @if ($addedRate['qty'] != 0)
                                                {{ $addedRate['qty'] }}

                                                @if (isset($addedRate['qtyUpdate']) && $addedRate['qtyUpdate'] == true)
                                                    {{-- @dd($addedRate['qtyUpdate']); --}}
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
                                            @if ($addedRate['unit_id'] != '' && $addedRate['unit_id'] != 0)
                                                {{ $addedRate['unit_id'] }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($addedRate['rate_type']) && ($addedRate['rate'] == 0 || $addedRate['rate'] != 0))
                                                {{-- @isset($addedRate['rate_type']) --}}
                                                @if ($addedRate['rate_type'] == 'fetch')
                                                    @if ($addedRate['rate'] > 0)
                                                        {{ $addedRate['rate'] }}
                                                        <x-button class="d-inline"
                                                            wire:click="resetRate({{ $key }})">
                                                            <span class="btn-inner">
                                                                <x-lucide-rotate-ccw
                                                                    class="w-4 h-4 text-gray-500"></x-lucide-rotate-ccw>
                                                            </span>
                                                        </x-button>
                                                    @else
                                                        <x-button
                                                            wire:click="viewDynamicSor({{ $addedRate['sor_itemno_child_id'] }},{{ $addedRate['sor_item_number'] }},{{ $key }})"
                                                            type="button" class="btn btn-soft-primary btn-sm">
                                                            <span class="btn-inner">
                                                                <x-lucide-eye class="w-4 h-4 text-gray-500" /> Get Rate
                                                            </span>
                                                        </x-button>
                                                    @endif
                                                @elseif ($addedRate['rate_type'] == 'other')
                                                    <x-input placeholder="Enter Rate"
                                                        wire:model="allAddedRateData.{{ $key }}.rate"
                                                        wire:blur="calculateValue({{ $key }})" />
                                                @else
                                                    {{ $addedRate['rate'] }}
                                                @endif
                                                {{-- @endisset --}}
                                            @else
                                                @if ($addedRate['rate'] != 0)
                                                    {{ $addedRate['rate'] }}
                                                @endif

                                                {{-- @if ($addedRate['is_row'] != '')
                                                    hi --}}
                                                {{-- <x-button>
                                                            <span class="btn-inner">
                                                                <x-lucide-edit class="w-4 h-4 text-gray-500"></x-lucide-edit>
                                                            </span>
                                                        </x-button> --}}
                                                {{-- @endif --}}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $addedRate['total_amount'] }}
                                        </td>
                                        <td>
                                            @if ($addedRate['operation'] == '' || ($addedRate['rate_no'] != '' && $addedRate['rate_no'] != 0))
                                                <button wire:click="editRow('{{ $addedRate['array_id'] }}')"
                                                    type="button" class="btn-soft-warning btn-sm">
                                                    <x-lucide-edit class="w-4 h-4 text-gray-500" /> Edit
                                                </button>
                                            @endif
                                            <x-button wire:click="viewRateModal({{ $addedRate['rate_no'] }})"
                                                type="button" class="btn btn-soft-primary btn-sm"
                                                style="{{ $addedRate['rate_no'] == 0 ? 'display:none;' : '' }}">
                                                <span class="btn-inner">
                                                    <x-lucide-eye class="w-4 h-4 text-gray-500" /> View
                                                </span>
                                            </x-button>


                                            {{-- @if ($arrayRow != $key) --}}
                                            {{-- <x-button
                                                    wire:click="confDeleteDialog({{ $addedRate['array_id'] }})"
                                                    type="button" class="btn btn-soft-danger btn-sm">
                                                    <span class="btn-inner">
                                                        <x-lucide-trash-2 class="w-4 h-4 text-gray-500" /> Delete
                                                    </span>
                                                </x-button> --}}
                                            <button
                                                onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                                wire:click="deleteRate('{{ $addedRate['array_id'] }}')" type="button"
                                                class="btn btn-soft-danger btn-sm">
                                                <span class="btn-inner">
                                                    <x-lucide-trash-2 class="w-4 h-4 text-gray-500" /> Delete
                                                </span>
                                            </button>
                                            {{-- <button onclick="showDeleteConfirmation({{ $addedRate['array_id'] }})" type="button" class="btn btn-soft-danger btn-sm">
                                                    <span class="btn-inner">
                                                        <x-lucide-trash-2 class="w-4 h-4 text-gray-500" /> Delete
                                                    </span>
                                                </button> --}}
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
    @endif
    @if ($openSorModal)
        <div>
            <div class="modal" id="{{ $openSorModalName }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                {{ $getSingleSor->table_no . ' - ' . $getSingleSor->title }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="example-table"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button"id="closeBtn" class="btn btn-secondary"
                                data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php
            $tableNo = $getSingleSor['table_no'];
            $pageNo = $getSingleSor['page_no'];

        @endphp
        <script>
            document.getElementById("closeBtn").addEventListener("click", function() {
                closeModal();
            });

            function closeModal() {
                $('#' + @json($openSorModalName)).modal('hide');
                window.Livewire.emit('closeModal1');
            }
            $(document).ready(function() {
                var clickableCellValues = [];
                $("#" + @json($openSorModalName)).modal({
                    backdrop: "static",
                    keyboard: false
                });
                var headerData = @json(json_decode($getSingleSor['header_data']));
                var rowData = @json(json_decode($getSingleSor['row_data']));
                headerData.forEach(function(column) {
                    var fun;
                    delete column.editor;

                    if (column.isClick) {
                        column.isClick = eval('(' + column.isClick + ')');
                        fun = column.isClick;
                    }
                    if (column.cellClick) {
                        column.cellClick = eval('(' + column.isClick + ')');
                        fun = column.cellClick;
                    }
                    if (typeof fun === "function") {
                        column.cellClick = function(e, cell) {
                            // Overwritten cellClick function
                            var getData = cell.getRow().getData();
                            var colId = cell.getField();
                            var allColumn = cell.getTable().columnManager.getColumns();
                            var colIdx = -1;
                            for (var i = 0; i < allColumn.length; i++) {
                                if (allColumn[i]['columns'] && allColumn[i]['columns'].length > 0) {
                                    var allGroupCol = allColumn[i]['columns'];
                                    for (var j = 0; j < allGroupCol.length; j++) {
                                        if (allGroupCol[j].getField() === colId) {
                                            colIdx = i + j;
                                            break;
                                        }
                                    }
                                } else {
                                    if (allColumn[i].getField() === colId) {
                                        colIdx = i;
                                        break;
                                    }
                                }
                            }
                            var getRowData = [{
                                // id: getData['id'],
                                id: @json($getSingleSor['id']),
                                desc: (getData['desc_of_item']) ? getData['desc_of_item'] : '',
                                rowValue: cell.getValue(),
                                itemNo: cell.getRow().getIndex(),
                                colPosition: colIdx
                            }];
                            var cnf = confirm("Are you sure " + cell.getValue() + " ?");
                            if (cnf) {
                                window.Livewire.emit('getRatePlaceWise', getRowData);
                                $('#' + @json($openSorModalName)).modal('hide');
                                // Add your custom code or logic here
                            }
                        };
                    }
                    if (column.columns) {
                        column.columns.forEach(function(subColumn) {
                            var subFun;
                            delete subColumn.editor;

                            if (subColumn.isClick) {
                                subFun = subColumn.isClick = eval('(' + subColumn.isClick + ')');
                            }
                            if (subColumn.cellClick) {
                                subFun = subColumn.cellClick = eval('(' + subColumn.cellClick + ')');
                            }
                            if (typeof subFun === "function") {
                                subColumn.cellClick = function(e, cell) {
                                    var subrowIndex = cell.getRow().getIndex();
                                    var getData = cell.getRow().getData();
                                    var colId = cell.getField();
                                    var allColumn = cell.getTable().columnManager.getColumns();
                                    var colIdx = -1;
                                    for (var i = 0; i < allColumn.length; i++) {
                                        if (allColumn[i]['columns'] && allColumn[i]['columns']
                                            .length > 0) {
                                            var allGroupCol = allColumn[i]['columns'];
                                            for (var j = 0; j < allGroupCol.length; j++) {
                                                if (allGroupCol[j].getField() === colId) {
                                                    colIdx = i + j;
                                                    break;
                                                }
                                            }
                                        } else {
                                            if (allColumn[i].getField() === colId) {
                                                colIdx = i;
                                                break;
                                            }
                                        }
                                    }
                                    var getRowData = [{
                                        // id: getData['id'],
                                        id: @json($getSingleSor['id']),
                                        desc: (getData['desc_of_item']) ? getData[
                                            'desc_of_item'] : '',
                                        rowValue: cell.getValue(),
                                        itemNo: subrowIndex,
                                        colPosition: colIdx
                                    }];
                                    var cnf = confirm("Are you sure " + cell.getValue() + " ?");
                                    if (cnf) {
                                        window.Livewire.emit('getRatePlaceWise', getRowData);
                                        $('#' + @json($openSorModalName)).modal('hide');
                                    }
                                };
                            }
                        });
                    }
                });

                var delay = 1000; // Delay time in milliseconds

                var delayPromise = new Promise(function(resolve) {
                    setTimeout(function() {
                        resolve();
                    }, delay);
                });

                delayPromise.then(function() {
                    var table = new Tabulator("#example-table", {
                        height: "auto",
                        layout: "fitColumns",
                        columns: headerData,
                        data: rowData,
                        dataTree: true, // Enable the dataTree module
                        dataTreeStartExpanded: true, // Optional: Expand all rows by default
                        dataTreeChildField: "_subrow", // Specify the field name for subrows
                        dataTreeChildIndent: 10, // Optional: Adjust the indentation level of subrows
                    });

                    // Title of the modal
                    var tableNo = @json($tableNo);
                    var pageNo = @json($pageNo);
                    var modalId = "exampleModal_" + tableNo + "_" + pageNo;

                    $("#" + @json($openSorModalName)).modal("show");
                });
            });
        </script>
    @endif
    @if ($isRateType)
        <div>
            <div class="modal" id="{{ $rateTypeModalName }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Select Rate Type</h5>
                        </div>
                        <div class="modal-body">
                            <div class="row" wire:key='rate-type' style="transition: all 2s ease-out">
                                <div class="col">
                                    <div class="form-group">
                                        <x-input label="TABLE NO" placeholder="TABLE NO" wire:key="item"
                                            value="{{ $fetchRatePlaceWise[0]['table_no'] }}" disabled />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <x-input label="PAGE NO" placeholder="PAGE NO" wire:key="item"
                                            value="{{ $fetchRatePlaceWise[0]['page_no'] }}" disabled />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <x-input label="ITEM NAME" placeholder="ITEM NAME" wire:key="item"
                                            value="{{ $fetchRatePlaceWise[0]['description'] }}" disabled />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <x-select wire:key="type" label="RATE TYPE" placeholder="Select Rate"
                                            wire:model.defer="rateType">
                                            @isset($fetchRatePlaceWise)
                                                @foreach ($fetchRatePlaceWise as $fetchRateType)
                                                    <x-select.option label="{{ $fetchRateType['operation'] }}"
                                                        value="{{ $fetchRateType['operation'] }}" />
                                                @endforeach
                                            @endisset
                                        </x-select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> --}}
                        <div class="modal-footer">
                            <button type="button"id="submitBtn" class="btn btn-success"
                                wire:click="getTypeWiseRate()">Submit</button>
                            <button type="button"id="closeBtn" class="btn btn-secondary"
                                data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.getElementById("closeBtn").addEventListener("click", function() {
                closeModal();
            });
            document.getElementById("submitBtn").addEventListener("click", function() {
                closeModal();
            });

            function closeModal() {
                $('#' + @json($rateTypeModalName)).modal('hide');
                window.Livewire.emit('closeModal1');
            }

            function closeRateTypeModal() {
                $('#' + @json($rateTypeModalName)).modal('hide');
            }
            $(document).ready(function() {
                var clickableCellValues = [];
                $("#" + @json($rateTypeModalName)).modal({
                    backdrop: "static",
                    keyboard: false
                });
                $("#" + @json($rateTypeModalName)).modal("show");
            });
        </script>
    @endif
    @if ($isItemModal)
        <div>
            <div class="modal" id="{{ $isItemModalName }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">No Rate Found on Selected Item.
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="example-table">Do you want to get item price?</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="yesBtn" class="btn btn-success">Yes</button>
                            <button type="button"id="closeBtn" class="btn btn-secondary"
                                data-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.getElementById("closeBtn").addEventListener("click", function() {
                closeModal();
            });
            document.getElementById("yesBtn").addEventListener("click", function() {
                getItemRate();
            });

            function getItemRate() {
                $('#' + @json($isItemModalName)).modal('hide');
                window.Livewire.emit('submitItemModal');
            }

            function closeModal() {
                $('#' + @json($isItemModalName)).modal('hide');
                window.Livewire.emit('closeItemModal');
            }
            $(document).ready(function() {
                $("#" + @json($isItemModalName)).modal({
                    backdrop: "static",
                    keyboard: false
                });
                $("#" + @json($isItemModalName)).modal("show");
            });
        </script>
    @endif


    @if ($openQtyModal)
        <livewire:components.modal.rate-analysis.unit-analysis-view-modal :sendArrayDesc="$sendArraysDesc" :arrayCount="$arrayCount"
            :unit_id="$sendArrayKey" :featureType="'RateAnalysis'" :editRate_id="$editRate_id" :part_no="$part_no" />
    @endif
    @if ($editRowModal)
        <livewire:components.modal.item-modal.edit-row-wise :editRowId='$editRowId' :editRowData='$editRowData' :editRate_id="$editRate_id"
            :featureType="'RateAnalysis'">
    @endif
</div>

{{-- <script>
    function showDeleteConfirmation(arrayId) {
        alert('hi');
        // Swal.fire({
        //     title: 'Are you sure?',
        //     text: 'This action cannot be undone.',
        //     icon: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#dc3545',
        //     cancelButtonColor: '#6c757d',
        //     confirmButtonText: 'Delete',
        //     cancelButtonText: 'Cancel'
        // }).then((result) => {
        //     if (result.isConfirmed) {
        //         // Call the deleteRate() function with the provided arrayId
        //         Livewire.emit('deleteEstimate', arrayId);
        //     }
        // });
    }
</script> --}}
