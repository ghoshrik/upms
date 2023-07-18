<div>
    <div class="row">
        <div class="col-md-4">
            <x-input label="Page No" placeholder="Page No" name="page_no" id="page_no" />
        </div>
        <div class="col-md-4">
            <x-input label="Table No" placeholder="Table No" name="table_no" id="table_no" />
        </div>
        <div class="clearfix"></div>
        <div class="mt-3 mb-3">
            <button id="addColumnBtn" class="btn btn-sm btn-primary">Add Column</button>
            <button id="addColumnGroupBtn" class="btn btn-sm btn-info">Add Column Group</button>
            <button id="addRow" class="btn btn-sm btn-warning">Add Row</button>
            <button id="addSubRow" class="btn btn-sm btn-warning">Add Sub Row</button>
            <button id="addSubSubRow" class="btn btn-sm btn-warning">Add Sub SubRow</button>
            <button id="getHeaderData" class="btn btn-sm btn-success">Save</button>
            <button id="getRow" class="btn btn-sm btn-warning">Get Row</button>
        </div>
    </div>
    <div id="table"></div>
</div>

<script>
    var data = [];
    var columns = [];
    var table = new Tabulator("#table", {
        height: 500,
        data: [],
        layout: "fitColumns",
        columns: [],
        dataTree: true, // Enable the dataTree module
        dataTreeStartExpanded: true, // Optional: Expand all rows by default
        dataTreeChildField: "_subrow", // Specify the field name for subrows
        dataTreeChildIndent: 10, // Optional: Adjust the indentation level of subrows
    });

    document.getElementById("addColumnBtn").addEventListener("click", function() {
        addColumn();
    });
    document.getElementById("addColumnGroupBtn").addEventListener("click", function() {
        addGroupColumn();
    });
    document.getElementById("getHeaderData").addEventListener("click", function() {
        getHeader();
    });
    document.getElementById("addRow").addEventListener("click", function() {
        addRow({});
    });
    document.getElementById("addSubRow").addEventListener("click", function() {
        addSubRow({});
    });
    document.getElementById("addSubSubRow").addEventListener("click", function() {
        addSubSubRow({});
    });
    document.getElementById("getRow").addEventListener("click", function() {
        getRow({});
    });

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
            var newColumn = {
                title: columnName,
                field: columnName.toLowerCase().replace(/\s+/g, "_"), // convert column name to field name
                editor: "input",
                cellClick: cellClickAble.cellClick.toString(),
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
            };

            for (var i = 0; i < columnCount; i++) {
                var columnName = prompt("Enter Column Name");
                var isClickable = confirm("The Cell is Clickable?");
                var cellClickAble = {};

                if (isClickable) {
                    cellClickAble.cellClick = function(e, cell) {
                        // Perform action when cell is clicked
                        alert("Cell clicked. Value: " + cell.getRow().getIndex() + "-" + cell.getValue());
                    };
                }
                if (columnName) {
                    var newColumn = {
                        title: columnName,
                        field: columnName.toLowerCase().replace(/\s+/g, "_") + "_" + groupName,
                        hozAlign: "right",
                        sorter: "number",
                        width: 150,
                        resizable: true,
                        editor: "input",
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
        var columnData = table.getColumnDefinitions();
        var rowData = table.getData();
        var table_no = $('#table_no').val()
        var page_no = $('#page_no').val()
        $.ajax({
            url: '/store-dynamic-sor',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: 'application/json',
            data: JSON.stringify({
                header_data: columnData,
                table_no: table_no,
                page_no: page_no,
                row_data: rowData
            }),
            success: function(response) {
                window.location.href = '{{ route('dynamic-sor') }}';
                window.$wireui.notify({
                    description: response.message,
                    icon: 'success'
                })
            },
            error: function(error) {
                console.error('Error storing data:', error);
            }
        });

    }

    function getRow() {
        var row = table.getData();
        var col = table.getColumnDefinitions();
        console.log(row, col);
    }

    function addRow() {
        console.log(table.getData().length);
        var newRowData = {
            id: table.getData().length + 1, // generate a new unique ID for the row
        };
        table.addRow(newRowData);
    }

    function addSubRow() {
        var rowId = prompt("Enter the ID of the row to add a subrow");
        var row = table.getRow(rowId);
        if (!row) {
            alert("Row with ID " + rowId + " does not exist.");
            return;
        }
        var subrows = row.getData()._subrow || []; // Retrieve existing subrows or create an empty array
        var newSubrow = {
            id: rowId + "." + (subrows.length + 1), // generate a unique ID for the subrow
        };
        subrows.push(newSubrow); // Add the new subrow to the array
        var newRowData = {
            _subrow: subrows, // Update the row's subrow property with the modified array
        };
        row.update(newRowData);
    }

    function addSubSubRow() {
        var rowId = prompt("Enter the ID of the row");
        var subrowId = prompt("Enter the ID of the subrow");
        var row = table.getRow(rowId);

        if (!row) {
            alert("Row with ID " + rowId + " does not exist.");
            return;
        }

        var subrow = row.getTreeChildren().find(function(childRow) {
            return childRow.getData().id === subrowId;
        });

        if (!subrow) {
            alert("Subrow with ID " + subrowId + " does not exist.");
            return;
        }

        var subsubrowData = {
            id: subrowId + "." + (subrow.getTreeChildren().length + 1),
        };

        subrow.addTreeChild(subsubrowData);

        // Refresh the table with updated data
        table.setData(table.getData());
    }

    function deleteButtonFormatter(cell, formatterParams, onRendered) {
        var rowIndex = cell.getRow().getIndex();
        if (rowIndex === table.getDataCount() - 1) {
            return "<button class='btn btn-danger btn-sm' onclick='deleteRow(" + rowIndex + ")'>Delete</button>";
        }
        return ""; // Return empty string for other rows
    }
</script>
