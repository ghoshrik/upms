<div>
    <div class="card">
        <div wire:loading.delay.longest>
            <div class="spinner-border text-primary loader-position" role="status"></div>
        </div>
        <div class="card-body" wire:loading.delay.longest.class="loading">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-lg-3">
                    <div class="form-group">
                        <x-select wire:key="deptCategory" label="{{ trans('cruds.sor.fields.dept_category') }}"
                            placeholder="Select {{ trans('cruds.sor.fields.dept_category') }}"
                            wire:model.defer="storeItem.dept_category_id"
                            x-on:select="$wire.getDeptCategorySORTables()">
                            @isset($fetchDropDownData['departmentCategory'])
                                @foreach ($fetchDropDownData['departmentCategory'] as $category)
                                    <x-select.option label="{{ $category['dept_category_name'] }}"
                                        value="{{ $category['id'] }}" />
                                @endforeach
                            @endisset
                        </x-select>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <x-select wire:key="dept1" label="Table No" placeholder="Select Table No"
                            wire:model.defer="storeItem.table_no" x-on:select="$wire.getPageNo()">
                            @foreach ($fetchDropDownData['tables'] as $table)
                                <x-select.option label="{{ $table['table_no'] }}" value="{{ $table['table_no'] }}" />
                            @endforeach
                        </x-select>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <x-select wire:key="dept" label="Page No" placeholder="Select Page No"
                            wire:model.defer="storeItem.page_no" x-on:select="$wire.getDynamicSor('parent')">
                            @foreach ($fetchDropDownData['pages'] as $page)
                                <x-select.option
                                    label="{{ $page['page_no'] . ($page['corrigenda_name'] != null ? ' - ' . $page['corrigenda_name'] : '') }}"
                                    value="{{ $page['id'] }}" />
                            @endforeach
                        </x-select>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <div class="form-group">
                        <x-input label="Item No" placeholder="Item No" wire:model.defer="storeItem.item_no"
                            wire:key="item" />
                    </div>
                </div>
            </div>
            @if ($storeItem['item_no'] != '')
                @foreach ($inputsData as $key => $inputData)
                    <div class="row mutipal-add-row">
                        <div class="col">
                            <div class="form-group">
                                <x-select wire:key="table_no{{ $key }}" label="Table No"
                                    placeholder="Select Table No"
                                    wire:model.defer="inputsData.{{ $key }}.table_no"
                                    x-on:select="$wire.getChildPageNo({{ $key }})">
                                    @isset($fetchDropDownData['child_tables'])
                                        @foreach ($fetchDropDownData['child_tables'] as $table)
                                            <x-select.option label="{{ $table['table_no'] }}"
                                                value="{{ $table['table_no'] }}" />
                                        @endforeach
                                    @endisset
                                </x-select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <x-select wire:key="page_no{{ $key }}" label="Page No"
                                    placeholder="Select Page No"
                                    wire:model.defer="inputsData.{{ $key }}.page_no"
                                    x-on:select="$wire.getDynamicSor({{ $key }})">
                                    @isset($fetchDropDownData[$key]['child_pages'])
                                        @foreach ($fetchDropDownData[$key]['child_pages'] as $page)
                                            <x-select.option
                                                label="{{ $page['page_no'] . ($page['corrigenda_name'] != null ? ' - ' . $page['corrigenda_name'] : '') }}"
                                                value="{{ $page['id'] }}" />
                                        @endforeach
                                    @endisset
                                </x-select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <x-textarea rows="2" wire:key="description.{{ $key }}"
                                    wire:model="inputsData.{{ $key }}.description"
                                    label="{{ trans('cruds.sor.fields.description') }}"
                                    placeholder="{{ trans('cruds.sor.fields.description') }}" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <x-select wire:key="unitmaster.{{ $key }}"
                                    label="{{ trans('cruds.sor.fields.unit') }}"
                                    placeholder="Select {{ trans('cruds.sor.fields.unit') }}"
                                    wire:model="inputsData.{{ $key }}.unit_id">
                                    @isset($fetchDropDownData['unitMaster'])
                                        @foreach ($fetchDropDownData['unitMaster'] as $units)
                                            <x-select.option label="{{ $units['unit_name'] }}"
                                                value="{{ $units['id'] }}" />
                                        @endforeach
                                    @endisset
                                </x-select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <x-input wire:key='qty.{{ $key }}'
                                    label="{{ trans('cruds.sor.fields.qty') }}"
                                    placeholder="{{ trans('cruds.sor.fields.qty') }}"
                                    wire:model.defer="inputsData.{{ $key }}.qty" />
                            </div>
                        </div>
                        <div class="col d-flex align-items-center">
                            <div class="col-md-12">
                                <button wire:click="removeRow({{ $key }})"
                                    class="btn btn-danger rounded-pill btn-ms"
                                    {{ count($inputsData) < 2 ? 'disabled' : '' }}>
                                    <span class="btn-inner">
                                        <x-lucide-trash-2 class="w-4 h-4 text-denger-500" />
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-md-3">
                    <button wire:click="addNewRow"
                        class="btn btn-primary rounded-pill btn-ms mutipal-row-add-button mt-3">
                        <span class="btn-inner">
                            <x-lucide-plus class="w-4 h-4 text-denger-500" />
                        </span>
                    </button>
                </div>
            @endif
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <button type="submit" wire:click='store'
                            class="btn btn-success rounded-pill float-right">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($viewModal)
        <div>
            <div class="modal" id="{{ $modalName }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                {{ $fetchDropDownData['getSor']['title'] }}</h5>
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
        <script>
            document.getElementById("closeBtn").addEventListener("click", function() {
                closeModal();
            });

            function closeModal() {
                $('#' + @json($modalName)).modal('hide');
                window.Livewire.emit('closeModal');
            }
            $(document).ready(function() {
                var clickableCellValues = [];
                $("#" + @json($modalName)).modal({
                    backdrop: "static",
                    keyboard: false
                });
                var headerData = @json(json_decode($fetchDropDownData['getSor']['header_data']));
                var rowData = @json(json_decode($fetchDropDownData['getSor']['row_data']));
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
                                id: getData['id'],
                                desc: (getData['desc_of_item']) ? getData['desc_of_item'] : '',
                                rowValue: cell.getValue(),
                                itemNo: getData['item_no'],
                                colPosition: colIdx
                            }];
                            var cnf = confirm("Are you sure " + cell.getValue() + " ?");
                            if (cnf) {
                                window.Livewire.emit('getRowValue', getRowData);
                                $('#' + @json($modalName)).modal('hide');
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
                                        id: getData['id'],
                                        desc: (getData['desc_of_item']) ? getData[
                                            'desc_of_item'] : '',
                                        rowValue: cell.getValue(),
                                        itemNo: getData['item_no'],
                                        colPosition: colIdx
                                    }];
                                    var cnf = confirm("Are you sure " + cell.getValue() + " ?");
                                    if (cnf) {
                                        window.Livewire.emit('getRowValue', getRowData);
                                        $('#' + @json($modalName)).modal('hide');
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

                    // Open the modal
                    var tableNo = @json($table_no);
                    var pageNo = @json($page_no);
                    var modalId = "exampleModal_" + tableNo + "_" + pageNo;

                    $("#" + @json($modalName)).modal("show");
                });
            });
        </script>
    @endif
</div>
