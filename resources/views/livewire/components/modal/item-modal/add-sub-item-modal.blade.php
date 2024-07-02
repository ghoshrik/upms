<div>
    <div wire:loading.delay.longest>
        <div class="spinner-border text-primary loader-position" role="status"></div>
    </div>
    <div class="modal" id="modal-{{ $rowParentId }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" style="display: block" wire:loading.delay.longest.class="loading">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Sub Item Modal
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div wire:loading.delay.longest>
                        <div class="spinner-border text-primary loader-position" role="status"></div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3 col-lg-3 col-sm-12 col-xs-12 mb-2">
                            <div class="form-group">
                                <x-select wire:key="depented-dwn" label="Dependent Row List" placeholder="Select Row"
                                    wire:model.defer="depDwnRowId" x-on:select="$wire.getDepDwnData()">
                                    @isset($fatchDropdownData['depDwnDatas'])
                                        @foreach ($fatchDropdownData['depDwnDatas'] as $item)
                                            <x-select.option label="{{ $item['id'] }}" value="{{ $item['id'] }}" />
                                        @endforeach
                                    @endisset
                                </x-select>
                            </div>
                        </div>
                        <div class="col col-md-3 col-lg-3 col-sm-12 col-xs-12 mb-2">
                            <div class="form-group">
                                <x-select wire:key="categoryType" label="{{ trans('cruds.estimate.fields.category') }}"
                                    placeholder="Select {{ trans('cruds.estimate.fields.category') }}"
                                    wire:model.defer="selectedCategoryId" x-on:select="$wire.changeCategory()"
                                    :options="[['name' => 'SOR', 'id' => 1], ['name' => 'Other', 'id' => 2]]" option-label="name" option-value="id" />
                            </div>
                        </div>
                    </div>
                    @if ($selectedCategoryId == 1)
                        <div class="row" style="transition: all 2s ease-out" wire:key='sub_{{ $selectedCategoryId }}'
                            x-data="{ showSearch: false }">
                            <div class="col">
                                <div class="form-group">
                                    <x-select wire:key="dept" label="{{ trans('cruds.estimate.fields.dept') }}"
                                        placeholder="Select {{ trans('cruds.estimate.fields.dept') }}"
                                        wire:model.defer="subItemData.dept_id" x-on:select="$wire.getDeptCategory()">
                                        @foreach ($fatchDropdownData['departments1'] as $department)
                                            <x-select.option label="{{ $department['department_name'] }}"
                                                value="{{ $department['id'] }}" />
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <x-select wire:key="category" label="{{ trans('cruds.estimate.fields.category') }}"
                                        placeholder="Select {{ trans('cruds.estimate.fields.category') }}"
                                        wire:model.defer="subItemData.dept_category_id"
                                        x-on:select="$wire.getVolumn()">
                                        @isset($fatchDropdownData['departmentsCategory'])
                                            @foreach ($fatchDropdownData['departmentsCategory'] as $deptCategory)
                                                <x-select.option label="{{ $deptCategory['dept_category_name'] }}"
                                                    value="{{ $deptCategory['id'] }}" />
                                            @endforeach
                                        @endisset
                                    </x-select>
                                </div>
                            </div>
                            <div class="col" x-show="!showSearch" style="margin-top: 26px">
                                <div class="form-group" style="margin-left: 15%;">
                                    <button type="button" @click="showSearch = !showSearch"
                                        class="{{ trans('global.add_btn_color') }}">
                                        <x-lucide-search class="w-4 h-4 text-gray-500" />
                                        Search SOR
                                    </button>
                                </div>
                            </div>
                            <div x-show="showSearch" class="col">
                                <div class="form-group search-sor" style="position: relative;">
                                    <x-input wire:key="search" class="dropbtn" wire:model.defer="searchKeyWord"
                                        wire:keydown.tab="textSearchSOR" label="Search SOR"
                                        placeholder="Write Here and Tab" />
                                    <button type="button" class="clear-btn" wire:click="clearSearch"
                                        style="position: absolute; top: 68%; right: 8px; transform: translateY(-50%); cursor: pointer; background: none; border: none;">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                            width="16" height="16">
                                            <path
                                                d="M17.29 6.71a1 1 0 0 0-1.42 0L12 10.59 7.71 6.29a1 1 0 1 0-1.42 1.42L10.59 12 6.29 16.29a1 1 0 0 0 0 1.42 1 1 0 0 0 1.42 0L12 13.41l4.29 4.3a1 1 0 0 0 1.42-1.42L13.41 12l4.3-4.29a1 1 0 0 0 0-1.42z">
                                            </path>
                                        </svg>
                                    </button>
                                    @isset($this->fatchDropdownData['searchDetails'])
                                        @if (count($this->fatchDropdownData['searchDetails']) > 0)
                                            <div class="dropdown-content"
                                                style="display:{{ $searchDtaCount ? $searchStyle : $searchStyle }}; position: absolute; top: 100%; left: 0; right: 0; z-index: 100; background-color: white; border: 1px solid #ccc; max-height: 200px; overflow-x: auto;">
                                                <ul style="list-style-type: none; padding: 0; margin: 0;">
                                                    @foreach ($this->fatchDropdownData['searchDetails'] as $list)
                                                        <li style="padding: 3px; border-bottom: 0.5px solid;">
                                                            <a href="javascript:void(0);"
                                                                wire:click="getDynamicSor({{ $list['id'] }})">
                                                                {{ $list['table_no'] }}<br />{!! $list['highlighted_row_data'] !!}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    @endisset
                                </div>
                            </div>
                            <div class="col-md-2" x-show="showSearch" style="margin-top: 26px">
                                <div class="form-group float-right">
                                    <button type="button" @click="showSearch = !showSearch; $wire.clearSearch()"
                                        class="btn btn-soft-danger rounded-pill"><x-lucide-x
                                            class="w-4 h-4 text-gray-500" />Close Search</button>
                                </div>
                            </div>
                            <div x-show="!showSearch" class="col">
                                <div class="form-group">
                                    <x-select wire:key="volume" label="Volume" placeholder="Select Volume"
                                        wire:model.defer="subItemData.volume" x-on:select="$wire.getTableNo()">
                                        @isset($fatchDropdownData['volumes'])
                                            @foreach ($fatchDropdownData['volumes'] as $volume)
                                                <x-select.option label="{{ getVolumeName($volume['volume_no']) }}"
                                                    value="{{ $volume['volume_no'] }}" />
                                            @endforeach
                                        @endisset
                                    </x-select>
                                </div>
                            </div>
                            <div x-show="!showSearch" class="col">
                                <div class="form-group">
                                    <x-select wire:key="table_no" label="Table No" placeholder="Select Table No"
                                        wire:model.defer="subItemData.table_no" x-on:select="$wire.getPageNo()">
                                        @isset($fatchDropdownData['table_no'])
                                            @foreach ($fatchDropdownData['table_no'] as $table)
                                                <x-select.option label="{{ $table['table_no'] }}"
                                                    value="{{ $table['table_no'] }}" />
                                            @endforeach
                                        @endisset

                                    </x-select>
                                </div>
                            </div>
                            <div x-show="!showSearch" class="col">
                                <div class="form-group">
                                    <x-select wire:key="page_no" label="Page No" placeholder="Select Page No"
                                        wire:model.defer="subItemData.id" x-on:select="$wire.getDynamicSor()">
                                        @foreach ($fatchDropdownData['page_no'] as $page)
                                            <x-select.option
                                                label="{{ $page['page_no'] . ($page['corrigenda_name'] != null ? ' - ' . $page['corrigenda_name'] : '') }}"
                                                value="{{ $page['id'] }}" />
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <x-textarea wire:key="sor_desc" rows="2"
                                        label="{{ trans('cruds.estimate.fields.description') }}"
                                        placeholder="{{ trans('cruds.estimate.fields.description') }}"
                                        wire:model.defer="subItemData.description" />
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    @if ($subItemData['unit_id'] == 0 || $subItemData['unit_id'] == '')
                                        <x-select wire:key="sub_unit_{{ rand(1, 1000) }}" label="Unit"
                                            placeholder="Select Unit" wire:model.defer="subItemData.unit_id">
                                            @foreach ($fatchDropdownData['units'] as $unit)
                                                <x-select.option label="{{ $unit['unit_name'] }}"
                                                    value="{{ $unit['id'] }}" />
                                            @endforeach
                                        </x-select>
                                    @else
                                        <x-input wire:key='sub_unit_{{ rand(1, 1000) }}' label="Unit Name"
                                            placeholder="Unit Name" wire:model.defer="subItemData.unit_id"
                                            readonly />
                                    @endif
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <x-input wire:key="sor_qty" label="{{ trans('cruds.estimate.fields.quantity') }}"
                                        placeholder="{{ trans('cruds.estimate.fields.quantity') }}"
                                        wire:model.defer="subItemData.qty" wire:blur="calculateValue"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '');" />
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <x-input wire:key="sor_rate"
                                        label="{{ trans('cruds.estimate.fields.per_unit_cost') }}"
                                        placeholder="{{ trans('cruds.estimate.fields.per_unit_cost') }}" readonly
                                        wire:model.defer="subItemData.rate" />
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <x-input wire:key="sor_cost" label="{{ trans('cruds.estimate.fields.cost') }}"
                                        placeholder="{{ trans('cruds.estimate.fields.cost') }}" disabled
                                        wire:model.defer="subItemData.total_amount" />
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($selectedCategoryId == 2)
                        <div class="row" wire:key='{{ $selectedCategoryId }}'>
                            <div class="col">
                                <div class="form-group">
                                    <x-input wire:key="other_name" wire:model.defer="subItemData.other_name"
                                        label="Item Name" placeholder="Item Name" />
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <x-select wire:key="sub_unit_{{ rand(1, 1000) }}" label="Unit" placeholder="Select Unit"
                                        wire:model.defer="subItemData.unit_id">
                                        @isset($fatchDropdownData['units'])
                                            @foreach ($fatchDropdownData['units'] as $value)
                                                <x-select.option label="{{ $value['unit_name'] }}"
                                                    value="{{ $value['unit_name'] }}" />
                                            @endforeach
                                        @endisset
                                    </x-select>
                                    {{-- <x-input wire:key='unit_' label="Unit Name" placeholder="Unit Name"
                                                    wire:model.defer="subItemData.unit_id" /> --}}
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <x-input wire:key="other_qty" wire:model.defer="subItemData.qty"
                                        wire:blur="calculateValue"
                                        label="{{ trans('cruds.estimate.fields.quantity') }}"
                                        placeholder="{{ trans('cruds.estimate.fields.quantity') }}"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '');" />
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <x-input wire:key="other_rate" wire:model.defer="subItemData.rate"
                                        wire:blur="calculateValue"
                                        label="{{ trans('cruds.estimate.fields.per_unit_cost') }}"
                                        placeholder="{{ trans('cruds.estimate.fields.per_unit_cost') }}"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '');" />
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <x-input wire:key="other_cost" wire:model.defer="subItemData.total_amount"
                                        label="{{ trans('cruds.estimate.fields.cost') }}" disabled
                                        placeholder="{{ trans('cruds.estimate.fields.cost') }}" />
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
                <div class="modal-footer">
                    <button type="button" id="closeBtn" class="btn btn-secondary"
                        data-dismiss="modal">Close</button>
                    <button type="button" id="addBtn" class="btn btn-success" wire:click="addSub">Add</button>
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
                                @isset($getSor->table_no)
                                    {{ $getSor->table_no . ' - ' . $getSor->title }}
                                @endisset
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="tabulator_table"></div>
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
            $tableNo = isset($subItemData['table_no']) ? $subItemData['table_no'] : $selectSor['table_no'];
            $pageNo = isset($subItemData['page_no']) ? $subItemData['page_no'] : $selectSor['page_no'];
        @endphp
        <script>
            document.getElementById("closeBtn").addEventListener("click", function() {
                closeModal();
            });

            function closeModal() {
                $('#' + @json($modalName)).modal('hide');
                window.Livewire.emit('closeDynamicModal');
            }
            $(document).ready(function() {
                var clickableCellValues = [];
                $("#" + @json($modalName)).modal({
                    backdrop: "static",
                    keyboard: false
                });
                var headerData = @json(json_decode($getSor['header_data']));
                var rowData = @json(json_decode($getSor['row_data']));
                headerData.forEach(function(column) {
                    var fun;
                    delete column.editor;
                    if (column.field === 'desc_of_item') {
                        column.frozen = true;
                    }
                    if (column.field === 'item_no') {
                        column.frozen = true;
                    }
                    if (column.field === 'unit') {
                        column.frozen = true;
                    }
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
                            var colName;
                            for (var i = 0; i < allColumn.length; i++) {
                                if (allColumn[i]['columns'] && allColumn[i]['columns'].length > 0) {
                                    var allGroupCol = allColumn[i]['columns'];
                                    for (var j = 0; j < allGroupCol.length; j++) {
                                        if (allGroupCol[j].getField() === colId) {
                                            colIdx = i + j;
                                            colName = allGroupCol[j].getField();
                                            colName = colName.replace(/_/g, ' ');
                                            break;
                                        }
                                    }
                                } else {
                                    if (allColumn[i].getField() === colId) {
                                        colIdx = i;
                                        colName = column.title;
                                        break;
                                    }
                                }
                            }
                            var getRowData = [{
                                id: getData['id'],
                                desc: (getData['desc_of_item']) ? getData['desc_of_item'] : '',
                                unit: (getData['unit']) ? getData['unit'] : '',
                                rowValue: cell.getValue(),
                                itemNo: cell.getRow().getIndex(),
                                colPosition: colIdx
                            }];
                            var cnf = confirm("Are you sure to select " + colName +
                                " Value = " + cell.getValue() + " ?");
                            if (cnf) {
                                window.Livewire.emit('getRowValueSub', getRowData);
                                // window.Livewire.emit('getRowValue', getData);
                                // window.Livewire.emit('getRowValue', clickableCellValues);
                                // var modalToggle = document.getElementById(@json($modalName));
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
                                    var colName;
                                    var colTitle = column.title;
                                    for (var i = 0; i < allColumn.length; i++) {
                                        if (allColumn[i]['columns'] && allColumn[i]['columns']
                                            .length > 0) {
                                            var allGroupCol = allColumn[i]['columns'];
                                            for (var j = 0; j < allGroupCol.length; j++) {
                                                if (allGroupCol[j].getField() === colId) {
                                                    colIdx = i + j;
                                                    colName = allGroupCol[j].getField();
                                                    colName = colName.replace(/_/g, ' ');
                                                    break;
                                                }
                                            }
                                        } else {
                                            if (allColumn[i].getField() === colId) {
                                                colIdx = i;
                                                colName = column.title;
                                                break;
                                            }
                                        }
                                    }
                                    var getRowData = [{
                                        id: getData['id'],
                                        desc: (getData['desc_of_item']) ? getData[
                                            'desc_of_item'] : '',
                                        unit: (getData['unit']) ? getData['unit'] : (
                                            getData['unit_' + colTitle]) ? getData[
                                            'unit_' + colTitle] : '',
                                        rowValue: cell.getValue(),
                                        itemNo: subrowIndex,
                                        colPosition: colIdx
                                    }];
                                    var cnf = confirm("Are you sure to select " + colName +
                                        " Value = " + cell.getValue() + " ?");
                                    if (cnf) {
                                        window.Livewire.emit('getRowValueSub', getRowData);
                                        // window.Livewire.emit('getRowValue', getData);
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
                    var table = new Tabulator("#tabulator_table", {
                        height: "711px",
                        columnVertAlign: "bottom",
                        layout: "fitDataFill",
                        columns: headerData,
                        columnHeaderVertAlign: "center",
                        data: rowData,
                        variableHeight: true,
                        variableWidth: true,
                        dataTree: true, // Enable the dataTree module
                        dataTreeStartExpanded: true, // Optional: Expand all rows by default
                        dataTreeChildField: "_subrow", // Specify the field name for subrows
                        dataTreeChildIndent: 10, // Optional: Adjust the indentation level of subrows
                    });

                    // Title of the modal
                    var tableNo = @json($tableNo);
                    var pageNo = @json($pageNo);
                    var modalId = "exampleModal_" + tableNo + "_" + pageNo;

                    $("#" + @json($modalName)).modal("show");
                });
            });
        </script>
    @endif
    <script>
        $(document).ready(function() {
            var modalId = "#modal-" + @json($rowParentId);
            $(modalId).modal({
                backdrop: "static",
                keyboard: false
            }).modal("show");
            $('#closeBtn').click(function() {
                $(modalId).modal("hide").on('hidden.bs.modal', function() {
                    setTimeout(() => {
                        $(this).css('display', '');
                    }, 1);
                });
                window.Livewire.emit('closeSubItemModal');
            });
            $('#addBtn').click(function() {
                $(modalId).modal("hide").on('hidden.bs.modal', function() {
                    setTimeout(() => {
                        $(this).css('display', '');
                    }, 1);
                });
            });
        });
    </script>
</div>
