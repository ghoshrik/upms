<div>
    @if ($allAddedEstimatesData != null)
        <div class="col-md-12 col-lg-12">
            <div class="card overflow-hidden">
                <div class="card-header d-flex justify-content-between flex-wrap">
                    <div class="header-title">
                        <h4 class="card-title mb-2">Added Rates List</h4>
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
                                    <button type="button" wire:click="expCalc"
                                        class="btn btn-soft-primary">Calculate</button>
                                </div>
                            </div>
                        </div>
                        <div class="col col-md-6 col-lg-6 mb-2">
                            <div class="btn-group float-right" role="group" aria-label="Basic example">
                                @if ($hideWithStackBtn == true)
                                    <button type="button" class="btn btn-soft-primary"
                                        wire:click="totalOnSelected('With Stacking')">With Stacking</button>
                                @endif
                                @if ($hideWithoutStackBtn == true)
                                    <button type="button" class="btn btn-soft-primary"
                                        wire:click="totalOnSelected('Without Stacking')">Without Stacking</button>
                                @endif
                                @if ($hideTotalbutton == true)
                                    <button type="button" class="btn btn-soft-primary"
                                        wire:click="totalOnSelected('Total')"
                                        @if (($openTotalButton && $totalOnSelectedCount != 1) || true) {{ '' }}@else {{ 'disabled' }} @endif>{{ trans('cruds.estimate.fields.total_on_selected') }}
                                    </button>
                                @endif
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
                                            {{-- {{ $addedEstimate['sor_item_number'] ?  $addedEstimate['sor_item_number'] : '---'}} --}}

                                            @if ($addedEstimate['sor_item_number'])
                                                {{-- {{ getSorItemNumber($addedEstimate['sor_item_number']) }} --}}
                                                {{ $addedEstimate['sor_item_number'] }}
                                            @elseif ($addedEstimate['rate_no'])
                                                {{ $addedEstimate['rate_no'] }}
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td class="text-wrap" style="width: 40rem">
                                            @if ($addedEstimate['sor_item_number'] || $addedEstimate['is_row'] == 0)
                                                {{ $addedEstimate['description'] }}
                                            @elseif ($addedEstimate['rate_no'])
                                                {{-- {{ getEstimateDescription($addedEstimate['rate_no']) }} --}}
                                                {{ $addedEstimate['description'] }}
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
                                            @endif
                                        </td>
                                        <td>
                                            @if ($addedEstimate['rate'] != 0)
                                                @if ($addedEstimate['rate'] == 'fetch' && $selectedArrKey != $key)
                                                    <x-button
                                                        wire:click="viewDynamicSor({{ $addedEstimate['sor_itemno_child_id'] }},{{ $addedEstimate['sor_item_number'] }},{{ $key }})"
                                                        type="button" class="btn btn-soft-primary btn-sm">
                                                        <span class="btn-inner">
                                                            <x-lucide-eye class="w-4 h-4 text-gray-500" /> Get Rate
                                                        </span>
                                                    </x-button>
                                                @else
                                                    {{ $addedEstimate['rate'] }}
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            {{ $addedEstimate['total_amount'] }}
                                        </td>
                                        <td>
                                            @if ($addedEstimate['rate_no'])
                                                <x-button wire:click="viewRateModal({{ $addedEstimate['rate_no'] }})"
                                                    type="button" class="btn btn-soft-primary btn-sm">
                                                    <span class="btn-inner">
                                                        <x-lucide-eye class="w-4 h-4 text-gray-500" /> View
                                                    </span>
                                                </x-button>
                                            @endif
                                            @if ($arrayRow == $key)
                                                <x-button
                                                    wire:click="confDeleteDialog({{ $addedEstimate['array_id'] }})"
                                                    type="button" class="btn btn-soft-danger btn-sm">
                                                    <span class="btn-inner">
                                                        <x-lucide-trash-2 class="w-4 h-4 text-gray-500" /> Delete
                                                    </span>
                                                </x-button>
                                                {{-- <button
                                                    onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                                    wire:click="deleteEstimate({{ $addedEstimate['array_id'] }})" type="button" class="btn btn-soft-danger btn-sm">
                                                    <span
                                                        class="btn-inner">
                                                        <x-lucide-trash-2 class="w-4 h-4 text-gray-500" /> Delete
                                                    </span>
                                                </button> --}}
                                                {{-- <button onclick="showDeleteConfirmation({{ $addedEstimate['array_id'] }})" type="button" class="btn btn-soft-danger btn-sm">
                                                    <span class="btn-inner">
                                                        <x-lucide-trash-2 class="w-4 h-4 text-gray-500" /> Delete
                                                    </span>
                                                </button> --}}
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
                            var cnf = confirm("Are you sure " + cell.getValue() + " col position " +
                                colIdx + " ?");
                            if (cnf) {
                                window.Livewire.emit('getRatePlaceWise',getRowData);
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
                                    var cnf = confirm("Are you sure " + cell.getValue() +
                                        " col position " + colIdx + " ?");
                                    if (cnf) {
                                        window.Livewire.emit('getRatePlaceWise',getRowData);
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
        //         // Call the deleteEstimate() function with the provided arrayId
        //         Livewire.emit('deleteEstimate', arrayId);
        //     }
        // });
    }
</script> --}}
