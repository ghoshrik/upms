<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col mb-2">
                    {{-- <x-input label="Table No*" placeholder="Table No" name="table_no" wire:model.defer="table_no" readonly /> --}}
                    <label for="Table/Chapter No" class="">Table/Chapter No</label>
                    @if ($fetchData['approver'] == '555' || $fetchData['approver'] == '99')
                        <span id="tbNoedit" class="editbtnlink">Edit</span>
                    @endif
                    <input type="text" class="form-control" placeholder="Table/Chapter No" id="tbl_cptr_no"
                        wire:model.defer="table_no" disabled />
                </div>
                <div class="col mb-2">
                    {{-- <x-input label="Table Title" placeholder="Table Title" wire:model.defer="tbl_title" readonly /> --}}
                    <label for="Table/Chapter Title" class="">Table/Chapter Title</label>
                    @if ($fetchData['approver'] == '555' || $fetchData['approver'] == '99')
                        <span id="tblTitleedit" class="editbtnlink">Edit</span>
                    @endif
                    <input type="text" class="form-control" placeholder="Table/Chapter Title"
                        wire:model.defer="tbl_title" id="tbl_cpter_title" disabled />
                </div>
                @if (!empty($corrigenda_name))
                    <div class="col mb-2">
                        <label for="Corrigenda Name" class="">Corrigenda Name</label>
                        @if ($fetchData['approver'] == '555' || $fetchData['approver'] == '99')
                            <span id="tblTitleedit" class="editbtnlink">Edit</span>
                        @endif
                        <input type="text" class="form-control" placeholder="Corrigenda Name"
                            wire:model.defer="corrigenda_name" id="tbl_corrigenda_name" disabled />
                    </div>
                @endif
                {{-- Only water resource department (subtitle) --}}
                @if (Auth::user()->department_id === 57)
                    <div class="col mb-2">
                        <div class="form-group">
                            <label for="Table/Chapter No">Sub Title </label>
                            <span id="subTitleedit" class="editbtnlink">Edit</span>
                            <textarea class="form-control" wire:model.defer="subTitle" id="sub_title" disabled placeholder="Your Sub Title"></textarea>
                        </div>
                    </div>
                @endif
            </div>
            <div class="row">
                {{-- Only water resource department (subtitle) --}}
                <div class="col-md-3 col-lg-3 col-sm-3 mb-2 mt-2">
                    <x-select label="Select Department Category" placeholder="Select Category"
                        wire:model.defer="dept_category_id" readonly>
                        @isset($dept_category)
                            <x-select.option label="{{ $dept_category['dept_category_name'] }}"
                                value="{{ $dept_category['id'] }}" />
                        @endisset
                    </x-select>
                </div>
                <div class="col-md-2 col-lg-2 col-sm-3 mb-2 mt-2">
                    <x-input label="Volume No*" placeholder="Volume No" name="volume_no" wire:model.defer="volume_no"
                        readonly />
                </div>
                <div class="col-md-2 col-lg-2 col-sm-3 mb-2 mt-2">
                    <x-input label="Page No*" placeholder="Page No" name="page_no" wire:model.defer="page_no"
                        readonly />
                </div>
                @if ($fetchData['approver'] == '555' || $fetchData['approver'] == '99')
                    <div class="col-md-2 col-lg-2 col-sm-3 mb-2 mt-2" id="newPage">
                        <x-input label="New Page No*" placeholder="New Page No" name="newpage_no" id="new_page_no"
                            required />
                    </div>
                @endif
                <div class="col-md-3 col-lg-3 col-sm-3 mb-2 mt-2">
                    <x-input label="Effective Date*" type="date" placeholder="Effective Date" name="effective_date"
                        wire:model.defer="effective_date" readonly />
                </div>
                @if ($fetchData['approver'] == '555' || $fetchData['approver'] == '99')
                    <div class="col-md-2 col-lg-2 mb-2 mt-2" id="nocorrignda">
                        <x-input label="No of Corrigenda*" placeholder="Corrigenda & Aggenda" name="corrigenda_no"
                            id="corrigenda_no" />
                        <span id="corrigenda_no_error"></span>
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-3 mb-2 mt-2" id="chEffdate">
                        <x-input label="Publish Corrigenda date" type="date" placeholder="Effective Date"
                            id="effective_to" name="effective_date" required />
                        <span id="effective_to_error"></span>
                    </div>
                @endif
                @if ($corrigenda_name != null && ($fetchData['approver'] == '555' || $fetchData['approver'] == '99'))
                    <div class="col-md-6 col-lg-12 col-sm-3 mb-2">
                        <label for="table Title" style="font-width:bold;">No of Corrigenda </label>
                        <input class="form-control" wire:model.defer="corrigenda_name" readonly />
                    </div>
                @endif

            </div>
        </div>
    </div>

    <div id="loadingModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-bg-content">
                <div class="modal-body">
                    <div class="loader-container clock">
                        <div class="loader">
                            <div class="arc"></div>
                        </div>
                    </div>
                    <p
                        style="padding: 72px 0px 0px 64px;text-align: center;font-size: 26px;font-weight: 400;color: aliceblue;">
                        Please Wait ... </p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-2">
        @if ($fetchData['approver'] == '555' || $fetchData['approver'] == '99')
            <button id="addRow" class="btn btn-primary rounded btn-sm">Add Row</button>
            <button id="ExtendNewRow" class="btn btn-secondary rounded btn-sm newAddTbl">
                <x-lucide-copy class="w-4 h-4 text-gray-500" />&nbsp; Copy Header
            </button>
            <button id="enableAction" class="btn btn-secondary rounded btn-sm extEnbTable">Enable Action</button>
            <button id="getStoreData" class="btn btn-sm btn-success rounded float-end saveUpdTable">Save</button>
            <button id="corrignStoreData" class="btn btn-sm btn-success rounded float-end">Update Addenda &
                Corrigenda</button>
            <button id="updateData" class="btn btn-success rounded float-end btn-sm ml-2 mr-1">Update
                Data</button>
            <button id="ApprovedData" type="button"
                class="btn btn-primary rounded btn-sm extUpdTable float-end ml-2 mr-1">Final Submit</button>

            <button id="EffectToDate" class="btn btn-warning rounded btn-sm">
                Corrigenda
            </button>
        @endif

        @if ($fetchData['approver'] === '-11' && Auth::user()->user_type === 3 && $fetchData['verifier'] === '-9')
            <button id="VerifiedData" type="button"
                class="btn btn-soft-success rounded btn-sm extUpdTable float-end ml-2 mr-1">Approve &
                Verify</button>
            <button id="RevertData" type="button"
                class="btn btn-soft-secondary rounded btn-sm float-end ml-2 mr-1">Revert</button>
        @endif

        <button id="pdfDownload" class="btn btn-secondary rounded btn-sm">
            <x-lucide-file-text class="w-4 h-4 text-gray-500" /> PDF
        </button>
        <button id="download-xlsx" class="btn btn-secondary rounded btn-sm">
            <x-lucide-sheet class="w-4 h-4 text-gray-500" /> Excel
        </button>

    </div>

    <div class="mt-2 mb-2" id="example-table"></div>
    <div class="mt-2 mb-2" id="copy_table"></div>
    <div class="row">
        <div class="col-md-12" id="existTextarea">
            <x-textarea label="Note " id="tbl_note" wire:model.defer="noteDtls" placeholder="Your Short Note *" />
        </div>
        @if ($fetchData['approver'] == '555' || $fetchData['approver'] == '99')
            <div class="col-md-12 col-lg-12 col-sm-6" id="copyTextarea">
                <label for="Note">Note</label>
                <textarea class="ckeditor form-control" name="wysiwyg-editor" id="tbl_note" placeholder="Your Short Note ">
                </textarea>
            </div>
        @endif
    </div>


    <style>
        .editbtnlink {
            cursor: pointer;
            color: blue;
            float: inline-end;
            font-size: 13px;
        }

        /*.tabulator .tabulator-header .tabulator-col .tabulator-col-content .tabulator-col-title {
            white-space: break-spaces !important;
            font-size: 10px;
            text-align: center;
        }

        .tabulator-row .tabulator-cell {
            box-sizing: content-box !important;
            white-space: break-spaces !important;
        }*/
        #loaderoverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 999;
            display: none;
        }

        .modal-bg-content {
            background: none;
            border: none;
            box-shadow: none;
        }

        .modal-dialog {
            margin: auto;
        }

        @keyframes rotate {
            100% {
                transform: rotate(360deg);
            }
        }

        .clock .loader {
            width: 100px;
            height: 100px;
        }

        .clock .loader .arc {
            position: relative;
            margin: 83% 0 0 185%;
            border: 2px solid #FFF;
            width: 150px;
            height: 150px;
            border-radius: 50%;
        }

        .clock .loader .arc::after,
        .clock .loader .arc::before {
            content: '';
            position: absolute;
            top: 4%;
            left: 48%;
            width: 4%;
            height: 46%;
            background-color: #FFF;
            transform-origin: 50% 100%;
            border-radius: 5px;
            animation: rotate 2s infinite linear;
        }

        .clock .loader .arc::after {
            height: 36%;
            top: 14%;
            animation-duration: 12s;
        }
    </style>
    <div id="loaderoverlay"></div>
</div>


<script>
    const SORApprove = @json($fetchData['approver']);
    const SORVerifier = @json($fetchData['verifier']);


    if ((SORApprove === "555") || (SORApprove === "99")) {
        document.getElementById("copy_table").style.display = "none";
        document.getElementById("newPage").style.display = "none";
        document.getElementById("getStoreData").style.display = "none";
        document.getElementById("copyTextarea").style.display = "none";
        document.getElementById("chEffdate").style.display = "none";
        document.getElementById("corrignStoreData").style.display = "none";
        document.getElementById("nocorrignda").style.display = "none";
        /* loading Screen */
        const LoadingModel = document.getElementById("loadingModal");
        const LoadverOverlay = document.getElementById("loaderoverlay");
        /* loading Screen */
    }

    var headerData = @json($header_data);
    //console.log(headerData);
    var rowdata = @json($row_data);



    var tableId = @json($selectedId);
    const title = @json($tbl_title);
    const pageNo = @json($page_no);
    const volume_no = @json($volume_no);
    const table_no = @json($table_no);
    const dept_category_id = @json($dept_category_id);
    const effective_date = @json($effective_date);
    const corrigenda = @json($corrigenda_name);

    //console.log(tableId, title, dept_category_id);
    // console.log(corrigenda);






    /*Edit button*/
    if ((SORApprove === "555") || (SORApprove === "99")) {
        if (@json(Auth::user()->department_id === 57)) {
            const subTitleEdit = document.querySelector('#subTitleedit');
            console.log(subTitleEdit);
            subTitleEdit.addEventListener('click', function() {
                console.log("nextInput");
                // const nextInput = this.nextElementSibling;
                const nextInput = document.querySelector('#sub_title');
                console.log(nextInput);
                if (this.textContent === 'Edit') {
                    this.textContent = 'Cancel';
                    // this.style.color = 'red';
                    if (nextInput && nextInput.tagName === 'TEXTAREA') {
                        nextInput.disabled = false;
                        nextInput.focus();
                    } else {
                        nextInput.disabled = true;
                    }
                } else {
                    this.textContent = 'Edit';
                    nextInput.disabled = true;
                }
            });
        }

        const tblNoEdit = document.querySelector('#tbNoedit');
        const tblTitleEdit = document.querySelector('#tblTitleedit');
        //console.log(tblNoEdit);
        tblNoEdit.addEventListener('click', function() {
            const nextInput = this.nextElementSibling;
            if (this.textContent === 'Edit') {
                this.textContent = 'Cancel';
                // this.style.color = 'red';
                if (nextInput && nextInput.tagName === 'INPUT') {
                    nextInput.disabled = false;
                    nextInput.focus();
                } else {
                    nextInput.disabled = true;
                }
            } else {
                this.textContent = 'Edit';
                nextInput.disabled = true;
            }
        });

        tblTitleEdit.addEventListener('click', function() {
            const nextInput = this.nextElementSibling;
            if (this.textContent === 'Edit') {
                this.textContent = 'Cancel';
                // this.style.color = 'red';
                if (nextInput && nextInput.tagName === 'INPUT') {
                    nextInput.disabled = false;
                    nextInput.focus();
                } else {
                    nextInput.disabled = true;
                }
            } else {
                this.textContent = 'Edit';
                nextInput.disabled = true;
            }
        });

    }
    console.log(SORApprove);
    /*Edit button*/

    var table = new Tabulator("#example-table", {
        height: "611px",
        // height: "auto",
        columnVertAlign: "bottom",
        // scrollVertical: "column",
        layout: "fitDatafill",
        // renderHorizontal: "virtual",
        // responsiveLayout: true,
        columns: headerData,
        columnHeaderVertAlign: "center",
        //autoColumns: true,
        data: rowdata,
        // headerClick: true,
        //selectable: true,
        dataTree: true, // Enable the dataTree module
        dataTreeStartExpanded: true, // Optional: Expand all rows by default
        dataTreeChildField: "_subrow", // Specify the field name for subrows
        dataTreeChildIndent: 10, // Optional: Adjust the indentation level of subrows
        printHeader: "<h1>" + @json($tbl_title) + "<h1><br/><h3>Table No " +
            @json($table_no) + "  Page No " + @json($page_no) + " </h3>",
        downloadDataFormatter: true,
        downloadComplete: false,
        downloadConfig: {
            columnHeaders: true,
            columnGroups: true,
            rowGroups: true,
            columnCalcs: true,
            dataTree: true,
        },
        rowFormatter: function(row) {
            const rowData = row.getData();
            if (rowData.background_color === "blue") {
                row.getElement().style.fontWeight = "bold";
                //cell.getElement().style.fontWeight = "bold";
            }
        },
        cellFormatter: function(cell) {
            let cellData = cell.getValue();

            console.log(cellData);
            if (cellData === "") {
                cell.getElement().style.fontWeight = "bold";
            }

        }

    });

    function findRowById(id, data) {
        for (const row of data) {
            if (row.id === id) {
                return row;
            } else if (row._subrow && row._subrow.length > 0) {
                const subrowResult = findRowById(id, row._subrow);
                if (subrowResult) {
                    return subrowResult;
                }
            }
        }
        return null;
    }


    /*custom pop up model*/
    const modal = document.getElementById('deleteModal');



    // if ((SORApprove === "555") || (SORApprove === "99")) {

    //     //}




    // }




    //sor Approval
    async function SORapprove() {
        const btnApprove = modal.querySelector('#btnModalAction');
        btnApprove.addEventListener('click', async function() {

            btnApprove.disabled = true;
            modal.querySelector('#model-cancel').disabled = true;
            const apiUrl = "{{ route('sor-approver') }}";
            const params = {
                id: @json($selectedId),
                approveValue: SORApprove
            };
            const urlWithParams = new URL(apiUrl);
            urlWithParams.search = new URLSearchParams(params).toString();
            await fetch(urlWithParams, {
                    method: "GET",
                    headers: {
                        'Content-Type': 'application/json',
                        Accept: 'application.json',
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // console.log(data.message);
                    if (data.status === true) {
                        $('#deleteModal').modal('hide');
                        window.$wireui.notify({
                            description: data.message,
                            icon: 'success'
                        });
                    } else {
                        window.$wireui.notify({
                            description: data.message,
                            icon: 'error'
                        });
                        window.location.reload(true);
                    }
                })

                .catch(error => {
                    console.log('Fetch Error', error);
                });
        });
    }


    if ((SORApprove === "555") || (SORApprove === "99")) {

        /* loading Screen */
        const LoadingModel = document.getElementById("loadingModal");
        const LoadverOverlay = document.getElementById("loaderoverlay");
        /* loading Screen */


        /* Corrigenda change Date */
        const CheffectDate = document.getElementById("EffectToDate");
        CheffectDate.addEventListener("click", function() {
            approveSOR.style.display = "none";
            document.getElementById("ExtendNewRow").style.display = "none";
            document.getElementById("addRow").style.display = "inline-block";
            document.getElementById("download-xlsx").style.display = "none";
            document.getElementById("pdfDownload").style.display = "none";
            document.getElementById("updateData").style.display = "none";
            CheffectDate.style.display = "none";
            document.getElementById("chEffdate").style.display = "block";
            document.getElementById("nocorrignda").style.display = "block";
            document.getElementById("corrignStoreData").style.display = "inline-block";

            /*
             * cell Edited color changes
             */
            table.on("cellEdited", function(cell) {
                const editedValue = cell.getValue();
                const column = cell.getColumn();
                const columnName = column.getField();

                const row = cell.getRow();
                const rowData = row.getData();
                const rowId = rowData.id;

                console.log("Edited Column:", columnName);
                console.log("Edited Row ID:", rowId);
                console.log("Edited Cell Value:", editedValue);
                const originalRowData = findRowById(rowId, @json($row_data));
                console.log(originalRowData);
                let newValue = cell.getValue();
                let oldValue = cell.getInitialValue();
                console.log(newValue, oldValue);
                if (cell.getValue() !== cell.getOldValue()) {
                    console.log(cell.getElement());
                    //cell.getElement().classList.add("updated-row");
                    row.getElement().classList.add("updated-row");
                    cell.getElement().style.fontWeight = "bold";
                    //var cellId = cell.getRow().getData().id;
                    //console.log(cellId);
                    const updateCellData = cell.getRow();
                    let updateRowData = row.getData();
                    updateRowData.background_color = "blue";
                    row.update(updateRowData);
                }
                updateBackgroundColor(rowId, "blue");
            });

        });

        function updateBackgroundColor(rowId, color) {
            console.log(rowId, color);
            let row = table.getRow(rowId);
            console.log(row);
            table.getRow(function(row) {
                return row.getData().id == rowId;
            });
            console.log(row.getData().id);
        }




        /*Date validation*/
        function isValidDate(dateString) {
            // Check if the input is a string
            if (typeof dateString !== 'string') {
                return false;
            }

            // Parse the input string as a Date object
            const date = new Date(dateString);

            // Check if the parsed date is valid
            // The "Invalid Date" value indicates an invalid date string
            if (date.toString() === 'Invalid Date') {
                return false;
            }

            // Check if the parsed year, month, and day match the input
            const [inputYear, inputMonth, inputDay] = dateString.split('-').map(Number);
            if (
                date.getFullYear() !== inputYear ||
                date.getMonth() + 1 !== inputMonth || // Months are zero-based
                date.getDate() !== inputDay
            ) {
                return false;
            }

            // Date is valid
            return true;
        }

        function isDateRangeValid(startDateStr, endDateStr) {
            if (!isValidDate(startDateStr) || !isValidDate(endDateStr)) {
                return false; // Invalid start or end date format
            }
            const startDate = new Date(startDateStr);
            const endDate = new Date(endDateStr);

            // Compare start date and end date
            if (startDate <= endDate) {
                return true; // Start date is not less than or equal to end date
            } else {
                return false; // Start date is after end date
            }
        }


        /*?New Data Entry*/
        var data = [];
        var columns = [];
        var exttable = new Tabulator("#copy_table", {
            height: "auto",
            columnVertAlign: "bottom",
            layout: "fitColumns",
            // responsiveLayout: true,
            // autoColumns: true,
            // renderHorizontal: "virtual",
            columnHeaderVertAlign: "center",
            columns: headerData,
            autoColumns: true,
            data: [],
            dataTree: true, // Enable the dataTree module
            dataTreeStartExpanded: true, // Optional: Expand all rows by default
            dataTreeChildField: "_subrow", // Specify the field name for subrows
            dataTreeChildIndent: 10, // Optional: Adjust the indentation level of subrows
        });



        /*corigenda data update */
        const corrignStoreData = document.getElementById('corrignStoreData');
        const effective_to_error = document.getElementById("effective_to_error");
        const corrigenda_no_error = document.getElementById("corrigenda_no_error");
        corrignStoreData.addEventListener("click", function(e) {
            e.preventDefault();
            var chdarte = document.getElementById("effective_to").value;
            const corrigenda_no = document.getElementById("corrigenda_no").value.trim();
            if ((isValidDate(chdarte)) == '') {

                effective_to_error.innerHTML = "Please select an effective date";
                effective_to_error.style.color = "red";
            } else if (corrigenda_no == '') {
                corrigenda_no_error.innerHTML = "please enter corrigenda name";
                corrigenda_no_error.style.color = 'red';
            } else {

                effective_to_error.style.display = "none";
                corrigenda_no_error.style.display = "none";
                corrignStoreData.disabled = true;
                LoadverOverlay.style.display = "block";
                LoadingModel.style.display = "block";
                table.deleteColumn("addBtn");
                table.deleteColumn("delBtn");
                var columnData = table.getColumnDefinitions();
                var rowData = table.getData();
                console.log(rowData, columnData);

                const jsonStr = JSON.stringify(rowData);
                const encoder = new TextEncoder();
                const jsonDataAsBytes = encoder.encode(jsonStr);
                const base64EncodedData = btoa(String.fromCharCode(...jsonDataAsBytes));
                console.log(volume_no);


                const base64entblNo = btoa(String.fromCharCode(...(encoder.encode(table_no))));
                const base64entblTitle = btoa(String.fromCharCode(...(encoder.encode(title))));
                const base64ennote = btoa(String.fromCharCode(...(encoder.encode(
                    @json($noteDtls)))));
                const base64headerData = btoa(String.fromCharCode(...(encoder.encode(JSON.stringify(
                    columnData)))));
                const base64CorgEnc = btoa(String.fromCharCode(...(encoder.encode(corrigenda_no))));

                $.ajax({
                    url: "{{ route('store-dynamic-sor') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: 'application/json',
                    //dataType: "json",
                    data: JSON.stringify({
                        tableId: tableId,
                        effective_to: chdarte,
                        header_data: base64headerData,
                        table_no: base64entblNo,
                        page_no: pageNo,
                        row_data: base64EncodedData,
                        title: base64entblTitle,
                        note: base64ennote,
                        volume_no: volume_no,
                        dept_category_id: dept_category_id,
                        corrigenda_name: base64CorgEnc
                    }),
                    success: function(response) {

                        if (response.status === true) {
                            LoadverOverlay.style.display = "none";
                            LoadingModel.style.display = "none";
                            copystoredata.disabled = false;
                            window.$wireui.notify({
                                description: response.message,
                                icon: 'success'
                            });
                            window.location.href = '{{ route('dynamic-sor') }}';
                        }

                    },
                    error: function(error) {
                        console.error('Error storing data:', error);
                        if (error) {
                            LoadverOverlay.style.display = "none";
                            LoadingModel.style.display = "none";
                            corrignStoreData.disabled = false;
                            window.$wireui.notify({
                                description: "storing data error !!!",
                                icon: 'error'
                            });
                        }
                    }
                });
            }
        });



        const AddRow = document.getElementById("addRow");
        AddRow.addEventListener("click", function() {
            addRow({});
        });


        const ExtendNewRow = document.getElementById("ExtendNewRow");
        ExtendNewRow.addEventListener("click", function() {
            // $(this).html('Add Row');
            // $(this).hide();
            approveSOR.style.display = "none";
            ExtendNewRow.style.display = "none";
            // document.getElementById("ExtendNewRow").value="Add Row";
            document.getElementById('example-table').style.display = "none";
            document.getElementById('existTextarea').style.display = "none";
            document.getElementById("copy_table").style.display = "block";
            // document.getElementById("addNewRow").style.display = "block";

            // document.getElementById("addRow").style.display = "none";
            document.getElementById("updateData").style.display = "none";
            document.getElementById("enableAction").style.display = "none";
            document.getElementById('EffectToDate').style.display = "none";

            document.getElementById("pdfDownload").style.display = "none";
            document.getElementById("download-xlsx").style.display = "none";


            document.getElementById("newPage").style.display = "block";
            document.getElementById("copyTextarea").style.display = "block";
            document.getElementById("getStoreData").style.display = "inline-block";

            document.getElementById('addRow').id = 'addnewTblRow';
            document.getElementById("addnewTblRow").addEventListener("click", function() {
                if (exttable.getData().length === 0) {
                    var col = exttable.getColumn("actions");
                    console.log(col);
                    if (!col) {
                        createAddDeleteButtons(exttable)
                    } else {
                        console.log("Actions column already exists.");
                    }
                }
                var newTble = {
                    id: exttable.getData().length + 1
                }
                exttable.addRow(newTble);
                var rows = exttable.getRows();
                if (rows.length > 0) {
                    var lastRowIndex = rows.length - 1;
                    console.log(lastRowIndex);
                    exttable.scrollToRow(rows[lastRowIndex]);

                }

            });
        });



        function updateColumnDefinition(field, updates) {
            var columns = table.getColumns();
            var columnToUpdate = columns.find(column => column.getField() === field);

            if (columnToUpdate) {
                var updatedColumnDef = {
                    ...columnToUpdate.getDefinition(),
                    ...updates
                };
                table.updateColumnDefinition(field, updatedColumnDef);
            } else {
                console.log("Column not found with field:", field);
            }
        }

        function createAddDeleteButtons(tablename) {
            var indexColumn = tablename.getColumn("id");
            console.log(indexColumn);
            if (indexColumn) {
                var updates = {
                    title: "Actions",
                    columns: [{
                        title: "Add",
                        field: "addBtn",
                        width: "5%",
                        formatter: addSubRowButtonFormatter,
                        cellClick: function(e, cell) {
                            var rowData = cell.getRow();
                            addSubRow(rowData);
                        }
                    }, {
                        title: "Delete",
                        field: "delBtn",
                        width: "5%",
                        formatter: delSubRowButtonFormatter,
                        cellClick: function(e, cell) {
                            var rowData = cell.getRow();
                            deleteRow(rowData);
                        },
                    }],
                    print: false,
                    headerSort: false,
                    width: "10%",
                };

                // If "Index" column is found, create the "Actions" column after it
                var indexField = indexColumn.getField();
                console.log(indexField);
                tablename.addColumn(updates, false,
                    indexField
                ); // 'false' indicates that the "Actions" column will be created after the 'indexField'

                // Alternatively, you can use the updateColumnDefinition method as you were using before:
                // table.updateColumnDefinition(updates.field, updates);
            }
            return;
        }

        // Enable Action Button Click Event Listener
        var enableActionButton = document.getElementById("enableAction");
        enableActionButton.addEventListener("click", function() {
            var col = table.getColumn("actions");
            console.log(col);
            if (!col) {
                createAddDeleteButtons(table);
                enableActionButton.disabled = true; // Disable the button after click
            } else {
                console.log("Actions column already exists.");
            }

        });

        function addSubRowButtonFormatter(cell, formatterParams, onRendered) {
            return '<button class="btn btn-sm btn-warning add-sub-btn"><i class="fa fa-plus" aria-hidden="true">+</i></button>';
        }

        function delSubRowButtonFormatter(cell, formatterParams, onRendered) {
            return '<button class="btn btn-sm btn-danger rounded add-sub-btn">X</button>';
        }

        const updbtn = document.getElementById("updateData");
        updbtn.addEventListener("click", function() {
            updateRow({});
        });

        function updateRow() {
            // Send an AJAX request to update the row data
            updbtn.disabled = true;
            LoadverOverlay.style.display = "block";
            LoadingModel.style.display = "block";
            var rowData = table.getData();
            // rowData = btoa(rowData)
            const departmentId = @json(Auth::user()->department_id === 57);

            const jsonStr = JSON.stringify(rowData);
            const encoder = new TextEncoder();
            const jsonDataAsBytes = encoder.encode(jsonStr);
            const base64EncodedData = btoa(String.fromCharCode(...jsonDataAsBytes));

            const tblNo = document.getElementById('tbl_cptr_no').value;
            const tblTitle = document.getElementById('tbl_cpter_title').value;
            const Note = document.getElementById('tbl_note').value;
            let requestData = {
                tableId: tableId,
                row_data: base64EncodedData,
                tbl_no: btoa(String.fromCharCode(...(encoder.encode(tblNo)))),
                tbl_title: btoa(String.fromCharCode(...(encoder.encode(tblTitle)))),
                note: btoa(String.fromCharCode(...(encoder.encode(Note)))),
            };
            if (departmentId) {

                requestData.subtitle = btoa(String.fromCharCode(...(encoder.encode(document
                    .getElementById('sub_title')
                    .value))));
            }
            // if ((tbl_no.value) || (tbl_title.value)) {
            //     requestData.tbl_no = tbl_no.value;
            //     requestData.tbl_title = tbl_title.value;
            // }
            console.log(requestData);
            console.log(tblNo);
            $.ajax({
                url: "{{ route('update-row-data') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: 'application/json',
                data: JSON.stringify(requestData),
                success: function(response) {
                    // window.location.href = '{{ route('dynamic-sor') }}';
                    console.log(response.status);
                    if (response.status === true) {
                        // $('#updateData').removeAttr("disabled");
                        LoadverOverlay.style.display = "none";
                        LoadingModel.style.display = "none";
                        updbtn.disabled = false;
                        // $("body").removeClass("loading");
                        // document.body.classList.remove("loading");
                        window.$wireui.notify({
                            description: response.message,
                            icon: 'success'
                        });
                    }
                    if (response.status === false) {
                        // $('#updateData').removeAttr("disabled");
                        LoadverOverlay.style.display = "none";
                        LoadingModel.style.display = "none";
                        updbtn.disabled = false;
                        // $("body").removeClass("loading");
                        // document.body.classList.remove("loading");
                        window.$wireui.notify({
                            description: response.message,
                            icon: 'error'
                        });
                    }

                },
                error: function(error) {
                    //console.error('Error storing data:', error);
                    if (error) {
                        // $('#updateData').removeAttr("disabled");
                        updbtn.disabled = false;
                        // $("body").removeClass("loading");
                        // document.body.classList.remove("loading");
                        window.$wireui.notify({
                            description: "Error storing data",
                            icon: 'error'
                        });
                    }

                }
            });
        }

        function getRow() {
            var row = table.getData();
            console.log(row);
        }

        function addRow() {
            var newRowData = {
                id: table.getData().length + 1, // generate a new unique ID for the row
            };
            table.addRow(newRowData);
            var rows = exttable.getRows();
            if (rows.length > 0) {
                var lastRowIndex = rows.length - 1;
                console.log(lastRowIndex);
                table.scrollToRow(rows[lastRowIndex]);

            }
            // var newTble = {id: exttable.getData().length + 1}
            // exttable.addRow(newTble);
        }

        function NewaddTblRow() {
            var newRowData = {
                id: exttable.getData().length + 1, // generate a new unique ID for the row
            };
            exttable.addRow(newRowData);
        }

        function addSubRow(parentRow) {
            var subrows = parentRow.getData()._subrow || [];
            var newSubrow = {
                id: parentRow.getData().id + "." + (subrows.length +
                    1), // generate a unique ID for the subrow
            };
            subrows.push(newSubrow); // Add the new subrow to the array

            var updatedParentRowData = {
                ...parentRow.getData(),
                _subrow: subrows,
                tree: true
            };

            // Update the parent row with the new subrows
            parentRow.update(updatedParentRowData);
        }


        const copystoredata = document.getElementById("getStoreData");
        copystoredata.addEventListener("click",
            function(e) {
                e.preventDefault();
                approveSOR.style.display = "none"
                const newpageno = $('#new_page_no').val();
                const newtblNote = $('#tbl_note').val();
                //const note = (@json($noteDtls))?@json($noteDtls):'';
                console.log(newpageno);
                if (newpageno == '') {
                    window.$wireui.notify({
                        description: 'Please fill up all fields',
                        icon: 'error'
                    })
                } else {
                    copystoredata.disabled = true;
                    exttable.deleteColumn("addBtn");
                    exttable.deleteColumn("delBtn");
                    var columnData = exttable.getColumnDefinitions();
                    var rowData = exttable.getData();
                    console.log(rowData, columnData);

                    const jsonStr = JSON.stringify(rowData);
                    const encoder = new TextEncoder();
                    const jsonDataAsBytes = encoder.encode(jsonStr);
                    const base64EncodedData = btoa(String.fromCharCode(...jsonDataAsBytes));


                    // const base64entblNo = btoa(String.fromCharCode(...(encoder.encode(table_no))));
                    // const base64entblTitle = btoa(String.fromCharCode(...(encoder.encode(title))));
                    // const base64ennote = btoa(String.fromCharCode(...(encoder.encode(@json($noteDtls)))));
                    // const base64headerData = btoa(String.fromCharCode(...(encoder.encode(JSON.stringify(columnData)))));
                    // const base64CorgEnc = btoa(String.fromCharCode(...(encoder.encode(corrigenda_no))));




                    $.ajax({
                        url: "{{ route('store-dynamic-sor') }}",
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        contentType: 'application/json',
                        data: JSON.stringify({
                            header_data: btoa(String.fromCharCode(...(encoder.encode(JSON.stringify(
                                columnData))))),
                            table_no: btoa(String.fromCharCode(...(encoder.encode(table_no)))),
                            page_no: newpageno,
                            row_data: base64EncodedData,
                            title: btoa(String.fromCharCode(...(encoder.encode(title)))),
                            //note:note,
                            note: btoa(String.fromCharCode(...(encoder.encode(newtblNote)))),
                            effective_date: effective_date,
                            volume_no: volume_no,
                            dept_category_id: dept_category_id
                        }),
                        success: function(response) {
                            copystoredata.disabled = false;
                            window.$wireui.notify({
                                description: response.message,
                                icon: 'success'
                            });
                            window.location.href = '{{ route('dynamic-sor') }}';
                        },
                        error: function(error) {
                            //console.error('Error storing data:', error);
                            if (error) {
                                // $('#updateData').removeAttr("disabled");
                                //updbtn.disabled = false;
                                // $("body").removeClass("loading");
                                // document.body.classList.remove("loading");
                                window.$wireui.notify({
                                    description: "Error storing data",
                                    icon: 'error'
                                });
                            }

                        }
                    });
                }
            });





        function deleteRow(row) {
            var confirmation = confirm(
                "Are you sure? It will delete the current row, and other indices will be updated.");
            if (!confirmation) {
                return;
            }

            var rowIndex = row.getIndex(); // Get the index of the row to be deleted
            row.delete(); // Delete the row

            // Loop through the remaining rows and update the "id" field
            table.getRows().forEach(function(row, index) {
                var rowData = row.getData();
                rowData.id = index + 1; // Update the "id" field to the new index
                row.update(rowData); // Update the row with the new data

                var subrows = row.getTreeChildren();
                subrows.forEach(function(subrow, subindex) {
                    var subrowData = subrow.getData();
                    subrowData.id = index + 1 + "." + (subindex +
                        1); // Update the "id" field for subrows
                    subrow.update(subrowData); // Update the subrow with the new data
                });
            });
        }






        /*Approve SOR*/
        const approveSOR = document.getElementById("ApprovedData");
        approveSOR.addEventListener('click', function() {
            approveSOR.style.display = "none";
            console.log(SORApprove);
            //console.log("yes");
            updbtn.disabled = true;
            CheffectDate.style.display = "none";
            copystoredata.style.display = "none";
            updbtn.style.display = "none";
            enableActionButton.style.display = "none";
            //addColumnGroupbtn.style.display = "none";
            //AddColumnbtn.style.display = "none";
            ExtendNewRow.style.display = "none";
            AddRow.style.display = "none";
            corrignStoreData.style.display = "none";
            //corrigndaBtn.style.display = "none";
            const modelcontent = modal.querySelector('.modal-body');
            modelcontent.innerHTML = '<p>Do you really want to Final Submit these records ?</p>';
            let btnCancel = modal.querySelector('#model-cancel');
            btnCancel.classList.add('rounded', 'btn-sm');
            btnCancel.textContent = 'No';
            $('#deleteModal').modal('show');
            cancelmodel(approveSOR);
            SORapprove();
            const modalAction = modal.querySelector('#btnModalAction');
            modalAction.classList.remove('btn-danger');
            modalAction.classList.add('btn-success', 'btn-sm', 'rounded');
            modalAction.textContent = 'Yes';

        });

        function cancelmodel(approveSOR) {
            const cancel = modal.querySelector('#model-cancel');
            cancel.addEventListener('click', function() {
                cancel.style.display = "inline-block";
                updbtn.disabled = false;
                CheffectDate.style.display = "inline-block";
                // copystoredata.style.display = "inline-block";
                updbtn.style.display = "inline-block"; //in no need
                enableActionButton.style.display = "inline-block";
                // addColumnGroupbtn.style.display = "block";
                // AddColumnbtn.style.display = "block";
                ExtendNewRow.style.display = "inline-block";
                AddRow.style.display = "inline-block";
                // modal.querySelector('#btnModalAction').style.display = "inline-block";
                if (approveSOR) {
                    approveSOR.style.display = "inline-block";
                }
                // corrignStoreData.style.display = "block";
                // corrigndaBtn.style.display = "inline-block";
                $('#deleteModal').modal('hide');
            });
        }
    }


    function compareJSON(json1, json2) {
        try {
            const obj1 = JSON.parse(json1);
            const obj2 = JSON.parse(json2);

            const stringifiedObj1 = JSON.stringify(obj1);
            const stringifiedObj2 = JSON.stringify(obj2);

            if (stringifiedObj1 === stringifiedObj2) {
                console.log('JSON objects are equal');
                return true;
            } else {
                console.log('JSON objects are not equal');
                return false;
            }
        } catch (error) {
            console.error('Invalid JSON format', error);
            return false;
        }
    }

    function validateAndParseJSON(jsonString) {
        try {
            const parsedJSON = JSON.parse(jsonString);
            return {
                isValid: true,
                parsedJSON
            };
        } catch (error) {
            return {
                isValid: false,
                error
            };
        }






    }
    const userType = @json(Auth::user()->user_type);
    console.log(userType);

    if (SORApprove === "-11" && userType === 3 && SORVerifier === "-9") {
        const btnVerify = document.getElementById("VerifiedData");
        const revertData = document.getElementById("RevertData");
        const token = document.head.querySelector('meta[name="csrf-token"]').getAttribute('content');

        btnVerify.addEventListener('click', function() {
            btnVerify.style.disabled = true;
            const modelcontent = modal.querySelector('.modal-body');
            modelcontent.innerHTML = '<p>Do you really want to Verify these records ?</p>';
            // let btnCancel = modal.querySelector('#model-cancel');
            // btnCancel.classList.add('rounded', 'btn-sm');
            $('#deleteModal').modal('show');
            cancelverifymodel();
            //base64Encode(table);
            // console.log(validateAndParseJSON(JSON.stringify(@json($row_data))));
            const result1 = validateAndParseJSON(JSON.stringify(table.getData()));
            const result2 = validateAndParseJSON(JSON.stringify(@json($row_data)));
            let jsonUpdateData, sorupdJson;
            let resJson = compareJSON(@json($row_data), table.getData());
            console.log(resJson);
            if (result1.isValid && result2.isValid) {
                // Both strings have valid JSON structure, now compare the parsed objects
                const isEqual = compareJSON(result1.parsedJSON, result2.parsedJSON);
                if (isEqual) {
                    jsonUpdateData = @json($row_data);
                    sorupdJson = 1;
                    console.log('The JSON objects are equal.');
                } else {
                    jsonUpdateData = table.getData();
                    sorupdJson = 2;
                    console.log('The JSON objects are different.');
                }
            } else {
                console.log('One or both of the JSON strings have an invalid structure.');
            }
            console.log(JSON.stringify(jsonUpdateData));
            SORverifier(jsonUpdateData, sorupdJson);
            const modalAction = modal.querySelector('#btnModalAction');
            modalAction.classList.remove('btn-danger');
            modalAction.classList.add('btn-success', 'btn-sm', 'rounded');
            modalAction.textContent = 'Verify';
            // console.log("Verify");
        });


        /*Revert data*/

        revertData.addEventListener('click', function() {
            revertData.style.disabled = true;
            $('#deleteModal').modal('show');
            const modelcontent = modal.querySelector('.modal-body');
            //console.log(modelcontent);
            const modeltitle = modal.querySelector('.modal-title');

            modeltitle.remove() ?? '';
            let svgTag = modal.querySelector('#sucSvg');
            //console.log(svgTag);
            svgTag.remove();
            // let textArea = document.createElement("textarea");
            // let label = document.createElement("label");
            // textArea.style.borderColor = "grey";
            // textArea.id = "myTextarea";
            // textArea.classList.add("form-control");
            // textArea.rows = "4";
            // textArea.cols = "50";
            // textArea.placeholder = "short Description of Revert .... ";
            // textArea.style.color = "gray";
            // label.innerHTML = "Description :";
            // label.style.cssFloat = "left";
            // label.setAttribute("for", "myTextarea");
            // modelcontent.appendChild(textArea);
            // textArea.parentNode.insertBefore(label, textArea);


            let message = document.createElement("p");
            message.innerHTML = '<strong>Do you really want to Revert these records ?</strong>';
            modelcontent.appendChild(message);

            const modalAction = modal.querySelector('#btnModalAction');
            modalAction.classList.remove('btn-danger');
            modalAction.classList.add('btn-success', 'btn-sm', 'rounded');
            modalAction.textContent = 'Send';
            modalAction.id = "btnSendAction";
            cancelRevertmodel();
            // RevertSOR();
            const revertSendBtn = document.getElementById('btnSendAction');

            revertSendBtn.addEventListener('click', async function() {
                revertSendBtn.disabled = true;
                modal.querySelector('#model-cancel').disabled = true;
                const apiUrl = "{{ route('sor-dept-revert') }}";
                const params = {
                    id: @json($selectedId),
                    SelectedStatus: SORApprove
                };
                console.log(params);
                const requestOptions = {
                    method: 'POST',
                    headers: {
                        // Accept: 'application.json;',
                        'Content-Type': 'application/json;charset=UTF-8',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify(params)
                };
                await fetch(apiUrl, requestOptions)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data.message);
                        if (data.status === true) {
                            $('#deleteModal').modal('hide');
                            window.$wireui.notify({
                                description: data.message,
                                icon: 'success'
                            });
                            // setTimeout(function() {
                            window.location.reload(true);
                            // }, 120000);
                        } else {
                            window.$wireui.notify({
                                description: data.message,
                                icon: 'error'
                            });
                            // window.location.href = "{{ route('sor-dept-verify') }}";
                            // setTimeout(function() {
                            window.location.reload(true);
                            // }, 120000);
                        }
                    })
            });
        });



        //sor Verifier
        async function SORverifier(jsonUpdateData, sorupdJson) {
            const btnApprove = modal.querySelector('#btnModalAction');

            const jsonStr = JSON.stringify(jsonUpdateData);
            const encoder = new TextEncoder();
            const jsonDataAsBytes = encoder.encode(jsonStr);
            const base64EncodedData = btoa(String.fromCharCode(...jsonDataAsBytes));

            btnApprove.addEventListener('click', async function() {
                // console.log(base64Encode(table));
                btnApprove.disabled = true;
                modal.querySelector('#model-cancel').disabled = true;
                const apiUrl = "{{ route('sor-dept-verify') }}";
                const params = {
                    id: @json($selectedId),
                    row_data: base64EncodedData,
                    is_update: sorupdJson,
                    approveValue: SORApprove
                };
                const requestOptions = {
                    method: 'POST',
                    headers: {
                        // Accept: 'application.json;',
                        'Content-Type': 'application/json;charset=UTF-8',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify(params)
                };

                // const urlWithParams = new URL(apiUrl);
                // urlWithParams.search = new URLSearchParams(params).toString();
                console.log(params);
                await fetch(apiUrl, requestOptions)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data.message);
                        if (data.status === true) {
                            $('#deleteModal').modal('hide');
                            window.$wireui.notify({
                                description: data.message,
                                icon: 'success'
                            });
                            window.location.reload(true);
                        } else {
                            window.$wireui.notify({
                                description: data.message,
                                icon: 'error'
                            });
                            // window.location.href = "{{ route('sor-dept-verify') }}";
                            window.location.reload(true);
                        }
                    })
            })
        }


        function cancelverifymodel() {
            const cancel = modal.querySelector('#model-cancel');

            cancel.addEventListener('click', function() {
                cancel.style.display = "inline-block";
                $('#deleteModal').modal('hide');
            });
        }

        function cancelRevertmodel() {
            const cancel = modal.querySelector('#model-cancel');
            cancel.addEventListener('click', function() {
                const modelcontent = modal.querySelector('.modal-body');
                console.log(modelcontent);
                cancel.style.display = "inline-block";
                $('#deleteModal').modal('hide');
            });
        }
    }


    document.getElementById("pdfDownload").addEventListener("click", function() {

        // var firstColumn = table.getColumnDefinitions()[0];
        // table.deleteColumn(firstColumn.field);
        var columnDefinitions = table.getColumns();
        let tableData = table.getData();
        var totalTableWidth = 0;

        columnDefinitions.forEach(function(column) {
            totalTableWidth += column.getWidth();
        });

        table.download("pdf", title + ".pdf", {

            orientation: "landscape", //set page orientation to portrait,landscape
            // title: Title, //add title to report
            jsPDF: {
                unit: "mm", //set units to inches
                format: "a3",
            },

            autoTable: { //advanced table styling
                head: [Object.keys(tableData[0])],
                styles: {
                    fillColor: [255, 255, 255],
                    textColor: [0, 0, 0],
                    lineColor: [0, 0, 0], // Specify the border color as black [R, G, B]
                    lineWidth: 0.5, // Set border line width
                    fontSize: 9, // Reduce the font size
                    // rowHeight: 20, // Reduce the row height
                    // cellWidth: 25,
                    valign: "middle",
                    overflow: "linebreak",
                    halign: "left",
                    tableWidth: "auto",
                    // columnWidth:30,

                },
                columnStyles: {
                    '*': {
                        textColor: [0, 0, 0], // [R, G, B] (black)
                        fillColor: [255, 255, 255],

                    },
                    1: {
                        cellWidth: 100,
                        cellPadding: 2
                    },

                },
                margin: {
                    top: 20,
                    bottom: 30,


                },
                headerVerticale: true,
                headerVertical: "bottom",
                startY: 20, // Start the table at a lower Y-coordinate to leave space for the title
                pageBreak: 'auto'


            },
            documentProcessing: function(doc) {
                doc.setFont("Arial");
                var pageSize = doc.internal.pageSize;
                var maxPortraitWidth = pageSize.width;


                // var footerText = volume_no + '(' + @json($page_no) + ')';
                var footerText = @json($page_no);
                var footerTextWidth = doc.getStringUnitWidth(footerText) * doc.internal
                    .getFontSize() / doc.internal.scaleFactor;
                var footerX = (pageSize.width - footerTextWidth) / 2;
                var footerY = pageSize.height - 10;
                console.log(footerX, footerY);
                doc.setFontSize(15);

                var pageCount = doc.internal.getNumberOfPages();
                for (var pageNo = 1; pageNo <= pageCount; pageNo++) {
                    doc.setPage(pageNo);

                    let textX = 15; // Positioning text     on the left side
                    //let firstTextY = 10; // Adjust this value to position the text vertically
                    let secondTextY = 10 +
                        4; // Position the second text under the first text

                    doc.setFontSize(12); // Set font size for table_no
                    doc.text(volume_no + " : " + @json($deptCateName), textX, 10);


                    if (@json($corrigenda_name)) {
                        let titleY = secondTextY +
                            5; // Positioning the title under the second text
                        doc.setFontSize(12);
                        doc.text(@json($corrigenda_name), textX, titleY);
                    }




                    // if (pageNo === 1) {
                    var textWidth = doc.getStringUnitWidth(table_no) * doc.internal
                        .getFontSize() /
                        doc.internal.scaleFactor;
                    var centertextX = (pageSize.width - textWidth) / 2;
                    // const
                    doc.text(table_no, centertextX, 7);

                    var tableNoWidth = doc.getStringUnitWidth(title) * doc.internal
                        .getFontSize() / doc.internal.scaleFactor;
                    var tableNoX = (pageSize.width - tableNoWidth) / 2;
                    let longLine = doc.splitTextToSize(title, 200);
                    var tableNoY =
                        14; // Adjust this value to position the table_no below the title
                    let subTitle = "(" + @json($subTitle) + ")";
                    doc.text(title + @json($subTitle) ?? '', tableNoX, tableNoY);
                    // }


                    if (pageNo === pageCount) {
                        if (@json($noteDtls)) {
                            //     let footernote = @json($noteDtls);
                            //     console.log(footernote);
                            /*var textfooterWidth = doc.getStringUnitWidth(footernote) * 10;
                            var pagefooterWidth = doc.internal.pageSize.width;
                            let footertextX = (doc.internal.pageSize.width - doc.getStringUnitWidth(
                                footerText) * 10) / 2;

                                */
                            // doc.text(footertextX, doc.internal.pageSize.height - 10,
                            //     @json($noteDtls));
                            // doc.text(@json($noteDtls), 15, 155);
                            /*if (@json($noteDtls)) {
                                doc.setFontSize(12);
                                doc.text(@json($noteDtls), 15, 155)
                            }*/
                            /*doc.setFontSize(12);
                            doc.text(footernote, 15, 155);*/

                            /*let rowCount = table.rowManager.rows.length;
                            console.log(rowCount);
                            let tableHeight = rowCount * 20;

                            let startY = 150;

                            let lastTableBottom = startY + tableHeight;
                            console.log(lastTableBottom);

                            let noteText = @json($noteDtls);
                            let noteX = 15; // X-coordinate for the note
                            let noteY = lastTableBottom + 10; // Adjust the vertical position as needed
                            console.log(noteY);

                            doc.setFontSize(12);
                            doc.text(noteText, noteX, noteY);*/

                            const lastPageHeight = doc.internal.pageSize.getHeight() - (doc
                                .previousAutoTable.finalY || 10);

                            //console.log(lastPageHeight);
                            var textHeight = doc.getTextDimensions(@json($noteDtls)).h;
                            if (lastPageHeight > textHeight) {
                                doc.setFontSize(12);
                                doc.text(@json($noteDtls), 15, doc.previousAutoTable
                                    .finalY +
                                    10);
                            } else {
                                doc.addPage();
                                doc.setFontSize(12);
                                doc.text(@json($noteDtls), 15, 20);
                            }
                        }
                    }
                    doc.text(footerText, footerX, footerY);



                    // if (pageNo === pageCount && pageSize.width === 841.89 && pageSize.height ===
                    //     1190.55) {
                    //right side text shown
                    let rightText = "Publish Date : " + @json($effective_date);
                    let rightTextWidth = doc.getStringUnitWidth(rightText) * doc.internal
                        .getFontSize()
                    var rightTextX = pageSize.width - rightTextWidth -
                        2; // Align to the right side with a margin of 15
                    doc.text(rightText, 360,
                        15); // Adjust vertical position as needed
                    // }



                }
            }
        });
        // table.addColumn(firstColumn);
    });




    document.getElementById("download-xlsx").addEventListener("click", function() {
        //table.deleteColumn(["delBtn","addBtn"]);
        table.download("xlsx", title + ".xlsx", {
            documentProcessing: function(workbook) {
                //workbook - sheetJS workbook object

                //set some properties on the workbook file
                workbook.Props = {
                    Title: title,
                    Subject: table_no,
                };

                return workbook;
            }
        });
    });
</script>
