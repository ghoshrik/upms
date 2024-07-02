<div>
    <div class="card">
        <div class="card-body">
            <h3 class="h6 mb-4" style="font-size:22px;font-weight:700;">Basic information</h3>
            <div class="row">
                <div class="col-md-4 col-lg-4 mb-2">
                    <label for="Table/Chapter No">Table/Chapter No <span style="color:red;">*</span></label>
                    <input type="text" class="form-control" placeholder="Table/Chapter No" name="table_no"
                        id="table_no" required />
                    {{--
                    <x-input label="Table/Chapter No*" placeholder="Table/Chapter No" name="table_no" id="table_no"
                        required /> --}}
                </div>

                <div class="col-md-8 mb-2 col-lg-8">
                    <label for="Table/Chapter Title">Table/Chapter Title<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" placeholder="Table/Chapter Title" name="tbl_title"
                        id="tbl_title" required />

                    {{--
                    <x-input label="Table/Chapter Title*" placeholder="Table/Chapter Title" id="tbl_title" required />
                    --}}
                </div>
                <div class="col-md-3 col-lg-3 mb-2 mt-2">
                    <label for="dept_category_id">Select Category <span style="color:red;">*</span></label>
                    <select class="form-control" aria-label="Select Category" id="dept_category_id">
                        <option selected>Select Category</option>
                        @isset($deptCategories)
                            @foreach ($deptCategories as $deptCategory)
                                <option value="{{ $deptCategory['id'] }}">{{ $deptCategory['dept_category_name'] }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>

                <div class="col-md-3 col-lg-3 mt-2 mb-2">
                    {{--
                    <x-input label="Volume No*" placeholder="Volume No" name="volume_no" id="volume_no" required /> --}}
                    <label for="volumn_no" class="">Select Volume</label>
                    <select class="form-control" aria-label="Select Volume" id="volume_no">
                        <option selected>Select Volume</option>
                        <option value="1">Volume I</option>
                        <option value="2">Volume II</option>
                        <option value="3">Volume III</option>
                    </select>
                </div>
                <div class="col-md-3 col-lg-3 mt-2 mb-2">
                    {{--
                    <x-input label="Page No*" placeholder="Page No" name="page_no" id="page_no" required /> --}}
                    <label for="Table/Chapter Title">Page No<span style="color:red;">*</span></label>
                    <input type="text" class="form-control" placeholder="Page No" name="page_no" id="page_no"
                        required />
                </div>

                <div class="col-md-3 col-lg-3 mb-2 mt-2">
                    <x-input label="Effective Date*" type="date" placeholder="Effective Date" name="effective_date"
                        id="effective_date" required />
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="mt-3 mb-3 col-md-6 col-sm-3 col-lg-12">
            <button id="addColumnBtn" class="btn btn-sm btn-primary rounded">Add Column</button>
            <button id="addColumnGroupBtn" class="btn btn-sm btn-secondary rounded">Add Column Group</button>
            <button id="addRow" class="btn btn-sm btn-warning rounded">Add Row</button>
            {{-- <button id="addSubRow" class="btn btn-sm btn-warning">Add Sub Row</button> --}}
            {{-- <button id="addSubSubRow" class="btn btn-sm btn-warning">Add Sub SubRow</button> --}}
            <button id="getHeaderData" class="btn btn-sm btn-success rounded float-end">Save</button>
            {{-- <button id="getRow" class="btn btn-sm btn-warning">Get Row</button> --}}
        </div>
    </div>

    <div id="table"></div>
    <div class="row mt-2 mb-2">
        <div class="col-md-6 col-lg-12 col-sm-3">
            <x-textarea label="Note " id="tbl_note" name="tbl_note" col="5" row="5"
                placeholder="Your Short Note *" />

        </div>
    </div>
    <style>
        .tabulator .tabulator-header .tabulator-col .tabulator-col-content .tabulator-col-title {
            white-space: break-spaces !important;
            font-size: 11px;
            text-align: center;
        }

        .tabulator-row .tabulator-cell {
            /* box-sizing: content-box !important; */
            white-space: break-spaces !important;
        }
    </style>

</div>

<script>
    var data = [];
    var columns = [];
    var table = new Tabulator("#table", {
        height: 500,
        headerSort: false,
        headerClick: true,
        columnVertAlign: "center",
        scrollHorizontal: true,
        columnHeaderVertAlign: "center",
        autoColumns: true,
        data: [],
        headerSort: false,
        headerClick: true,
        //layout: "fitColumns",
        columnHeaderVertAlign: "center",
        columns: [{
                title: "Index",
                field: "id",
                print: false,
                download: false,
                width: "5%",
                frozen: true,
                headerSort: false,
                headerWordWrap: true
            },
            {
                title: "Actions",
                field: "actions",
                columns: [{
                    title: "Add",
                    field: "addBtn",
                    width: 80,
                    headerSort: false,
                    formatter: addSubRowButtonFormatter, // Use the custom formatter to render the button
                    cellClick: function(e, cell) {
                        var rowData = cell.getRow();
                        addSubRow(rowData);
                    }
                }, {
                    title: "Delete",
                    field: "delBtn",
                    width: 80,
                    headerSort: false,
                    formatter: delSubRowButtonFormatter, // Use the custom formatter to render the button
                    cellClick: function(e, cell) {
                        var rowData = cell.getRow();
                        deleteRow(rowData);
                    },
                }],
                print: false,
                headerSort: false, // Disable sorting on the Actions column
                width: 80,

            }, {
                title: "Item No/Sl No",
                field: "item_no",
                editor: "input",
                width: "8%",
                headerSort: false,
                headerWordWrap: true,
            }, {
                title: "Description of Items",
                field: "desc_of_item",
                editor: "textarea",
                selectContents: true,
                height: "80%",
                headerSort: false,
                columnHeaderVertAlign: "center",
                width: 250,
                headerWordWrap: true,
                editorParams: {
                    elementAttributes: {
                        class: "tabulator-editor-textarea",
                    },
                },
            }
        ],
        dataTree: true, // Enable the dataTree module
        dataTreeStartExpanded: true, // Optional: Expand all rows by default
        dataTreeChildField: "_subrow", // Specify the field name for subrows
        dataTreeChildIndent: 10, // Optional: Adjust the indentation level of subrows
    });

    function addSubRowButtonFormatter(cell, formatterParams, onRendered) {
        return '<button class="btn btn-sm btn-warning rounded add-sub-btn"><i class="fa fa-plus" aria-hidden="true">+</i></button>';
    }

    function delSubRowButtonFormatter(cell, formatterParams, onRendered) {
        return '<button class="btn btn-sm btn-danger rounded add-sub-btn">X</button>';
    }


    function customheader(e, column) {
        var fieldName = column.getField();
        console.log(fieldName)
        // Prompt for a new name
        var newFieldName = prompt("Enter a new name for the column:", fieldName);

        if (newFieldName && newFieldName.trim() !== "") {
            // Update the column definition
            column.updateDefinition({
                title: newFieldName,
                field: newFieldName
            });

            // Update the table to reflect the changes
            table.redraw();

            // table.addColumn(newFieldName);
        }
    }

    document.getElementById("addColumnBtn").addEventListener("click", function() {
        addColumn();
    });
    document.getElementById("addColumnGroupBtn").addEventListener("click", function() {
        addGroupColumn();
    });
    const storeBtn = document.getElementById("getHeaderData");
    storeBtn.addEventListener("click", function(e) {
        e.preventDefault();

        getHeader();
    });
    document.getElementById("addRow").addEventListener("click", function() {
        addRow({});
    });
    // document.getElementById("addSubRow").addEventListener("click", function() {
    //     addSubRow({});
    // });
    // document.getElementById("addSubSubRow").addEventListener("click", function() {
    //     addSubSubRow({});
    // });
    // document.getElementById("getRow").addEventListener("click", function() {
    //     getRow({});
    // });

    function addColumn() {
        var columnName = prompt("Enter Column Name");
        if (columnName) {
            var isClickable = confirm("The Cell is Clickable?");
            var cellClickAble = {};

            if (isClickable) {
                cellClickAble.cellClick = function(e, cell) {
                    // alert("Cell clicked. Value: " + cell.getRow().getIndex() + "-" + cell.getValue());
                    // rowIndex = cell.getRow().getIndex();
                    // cellValue = cell.getValue();
                };
            }
            var cellClickFunction = function(e, cell) {
                // Perform action when cell is clicked
            };
            var newColumn = {
                title: columnName,
                field: columnName.toLowerCase().replace(/\s+/g, "_"), // convert column name to field name
                editor: "input",
                headerSort: false,
                headerClick: true,
                width: "6px",
                headerWordWrap: true,
                titleFormatter: function(cell, formatterParams, onRendered) {
                    return "<div class='tabulator-cell-wrap' style='wrap-space:normal;'>" + cell.getValue() +
                        "</div>";
                },
                isClick: (isClickable) ? cellClickFunction.toString() : '',
                ...cellClickAble // Spread the cellClickAble object properties into newColumn

            };

            table.addColumn(newColumn);
        }
    }

    function addGroupColumn() {
        var groupName = prompt("Enter Group Column Name");
        if (groupName) {
            var columnCount = parseInt(prompt("Enter number of columns"));

            if (isNaN(columnCount) || columnCount <= 0) {
                alert("Invalid column count");
                return;
            }

            var newGroupColumn = {
                title: groupName,
                columns: [],
                headerWordWrap: true,
            };

            for (var i = 0; i < columnCount; i++) {
                var columnName = prompt("Enter Column Name");
                var isClickable = confirm("The Cell is Clickable?");
                var cellClickAble = {};

                if (isClickable) {
                    cellClickAble.cellClick = function(e, cell) {
                        // Perform action when cell is clicked
                        //alert("Cell clicked. Value: " + cell.getRow().getIndex() + "-" + cell.getValue());
                    };
                }
                if (columnName) {
                    var cellClickFunction = function(e, cell) {
                        // Perform action when cell is clicked
                    };
                    var newColumn = {
                        title: columnName,
                        field: columnName.toLowerCase().replace(/\s+/g, "_") + "_" + groupName,
                        hozAlign: "center",
                        sorter: "number",
                        width: "8px",
                        headerSort: false,
                        resizable: true,
                        editor: "input",
                        headerHozAlign: "center",
                        headerWordWrap: true,
                        titleFormatter: function(cell, formatterParams, onRendered) {
                            return "<div style='white-space:normal;'>" + cell.getValue() + "</div>";
                        },
                        isClick: (isClickable) ? cellClickFunction.toString() : '',
                        ...cellClickAble
                    };

                    newGroupColumn.columns.push(newColumn);
                }
            }
            columns.push(newGroupColumn);
            table.addColumn(newGroupColumn);
        }
    }

    function getHeader() {
        //var columnData = table.getColumnDefinitions();
        //var rowData = table.getData();
        var table_no = $('#table_no').val()
        var page_no = $('#page_no').val()
        var tbl_title = $('#tbl_title').val();
        var note = $('#tbl_note').val();
        var volume_no = $('#volume_no').val();
        var effective_date = $('#effective_date').val();
        var dept_category_id = $('#dept_category_id').val();
        console.log(dept_category_id);

        if (table_no == '' || page_no == '' || tbl_title == '' || volume_no == '' || effective_date == '' ||
            dept_category_id == '') {
            window.$wireui.notify({
                description: 'Please fill up all fields',
                icon: 'error'
            });
        } else {

            storeBtn.disabled = true;
            table.deleteColumn("addBtn");
            table.deleteColumn("delBtn");
            var columnData = table.getColumnDefinitions();
            var rowData = table.getData();

            const jsonStr = JSON.stringify(rowData);
            const encoder = new TextEncoder();
            const jsonDataAsBytes = encoder.encode(jsonStr);
            const base64EncodedData = btoa(String.fromCharCode(...jsonDataAsBytes));


            const jsonHeader = JSON.stringify(columnData);
            const jsonHeaderAsBytes = encoder.encode(jsonHeader);
            const b64enctblHeader = btoa(String.fromCharCode(...jsonHeaderAsBytes));

            $.ajax({
                url: "{{ route('store-dynamic-sor') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: 'application/json',
                data: JSON.stringify({
                    header_data: b64enctblHeader,
                    table_no: btoa(String.fromCharCode(...(encoder.encode(table_no)))),
                    page_no: page_no,
                    row_data: base64EncodedData,
                    note: btoa(String.fromCharCode(...(encoder.encode(note)))),
                    title: btoa(String.fromCharCode(...(encoder.encode(tbl_title)))),
                    effective_date: effective_date,
                    volume_no: volume_no,
                    dept_category_id: dept_category_id
                }),
                success: function(response) {
                    if (response.status === true) {
                        storeBtn.disabled = false;
                        window.$wireui.notify({
                            description: response.message,
                            icon: 'success'
                        })
                        window.location.href = '{{ route('dynamic-sor') }}';

                    }
                },
                error: function(error) {
                    console.error('Error storing data:', error);
                    if (error) {
                        window.$wireui.notify({
                            description: "keyword error",
                            icon: 'error'
                        });
                    }
                }
            });
        }







    }

    function getRow() {
        /*var row = table.getData();
        var col = table.getColumnDefinitions();
        console.log(row, col);*/
        var col = table.getColumnDefinitions();
        table.deleteColumn("addBtn");
        table.deleteColumn("delBtn");
        var col = table.getColumnDefinitions();


        console.log(col);
    }

    function addRow() {
        console.log(table.getData().length);
        var newRowData = {
            id: table.getData().length + 1, // generate a new unique ID for the row
        };
        table.addRow(newRowData);
        var rows = table.getRows();
        if (rows.length > 0) {
            var lastRowIndex = rows.length - 1;
            console.log(lastRowIndex);
            table.scrollToRow(rows[lastRowIndex]);

        }
    }

    function addSubRow(parentRow) {
        var subrows = parentRow.getData()._subrow || [];
        var newSubrow = {
            id: parentRow.getData().id + "." + (subrows.length + 1), // generate a unique ID for the subrow
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
    // Add Sub Row Button Click Event Listener
    //  document.getElementById("addSubRow").addEventListener("click", function() {
    //     var allRows = table.getData();
    //     var rootRows = allRows.filter(row => !row._subrow);

    //     if (rootRows.length === 0) {
    //         // If there are no root rows, add a new root row
    //         addRow({});
    //     } else {
    //         // Add a subrow under the last root row
    //         var lastRootRow = rootRows[rootRows.length - 1];
    //         addSubRow(lastRootRow);
    //     }
    // });


    // function addSubRow(rowIndex) {
    //     var row = table.getRow(rowIndex);

    //     if (!row) {
    //         alert("Row with index " + rowIndex + " does not exist.");
    //         return;
    //     }

    //     var subrows = row.getData()._subrow || []; // Retrieve existing subrows or create an empty array
    //     var newSubrow = {
    //         // id: row.getData().id + "." + (subrows.length + 1), // generate a unique ID for the subrow
    //         id: row.getData().id + (subrows.length + 1), // generate a unique ID for the subrow
    //     };
    //     subrows.push(newSubrow); // Add the new subrow to the array

    //     var updatedRowData = {
    //         ...row.getData(), // Spread the properties of the current row
    //         _subrow: subrows, // Update the row's subrow property with the modified array
    //     };

    //     // Update the current row with the new subrows
    //     row.update(updatedRowData);
    // }

    // function addSubRow() {
    //     var rowId = prompt("Enter the ID of the row to add a subrow");
    //     var row = table.getRow(rowId);
    //     if (!row) {
    //         alert("Row with ID " + rowId + " does not exist.");
    //         return;
    //     }
    //     var subrows = row.getData()._subrow || []; // Retrieve existing subrows or create an empty array
    //     var newSubrow = {
    //         id: rowId + "." + (subrows.length + 1), // generate a unique ID for the subrow
    //     };
    //     subrows.push(newSubrow); // Add the new subrow to the array
    //     var newRowData = {
    //         _subrow: subrows, // Update the row's subrow property with the modified array
    //     };
    //     row.update(newRowData);
    // }

    // function addSubSubRow() {
    //     var rowId = prompt("Enter the ID of the row");
    //     var subrowId = prompt("Enter the ID of the subrow");
    //     var row = table.getRow(rowId);

    //     if (!row) {
    //         alert("Row with ID " + rowId + " does not exist.");
    //         return;
    //     }

    //     var subrow = row.getTreeChildren().find(function(childRow) {
    //         return childRow.getData().id === subrowId;
    //     });

    //     if (!subrow) {
    //         alert("Subrow with ID " + subrowId + " does not exist.");
    //         return;
    //     }

    //     var subsubrowData = {
    //         id: subrowId + "." + (subrow.getTreeChildren().length + 1),
    //     };

    //     subrow.addTreeChild(subsubrowData);

    //     // Refresh the table with updated data
    //     table.setData(table.getData());
    // }

    // function deleteButtonFormatter(cell, formatterParams, onRendered) {
    //     var rowIndex = cell.getRow().getIndex();
    //     if (rowIndex === table.getDataCount() - 1) {
    //         return "<button class='btn btn-danger btn-sm' onclick='deleteRow(" + rowIndex + ")'>Delete</button>";
    //     }
    //     return ""; // Return empty string for other rows
    // }
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
</script>
