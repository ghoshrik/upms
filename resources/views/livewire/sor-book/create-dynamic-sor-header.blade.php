<div>
    <div class="row">
        <div class="col-md-4">
            <x-input label="Page No" placeholder="Page No" name="page_no" id="page_no" />
        </div>
        <div class="col-md-4">
            <x-input label="Table No" placeholder="Table No" name="table_no" id="table_no" />
        </div>
    </div>
    <div id="table"></div>
    <button id="addColumnBtn" class="btn btn-primary">Add Column</button>
    <button id="addColumnGroupBtn" class="btn btn-info">Add Column Group</button>
    <button id="addRow" class="btn btn-warning">Add Row</button>
    <button id="getHeaderData" class="btn btn-success">Save</button>
    {{-- <button id="getRow" class="btn btn-warning">Get Row</button> --}}
</div>

<script>
    var data = [];
    var columns = [];
    var table = new Tabulator("#table", {
        height: 205,
        data: [],
        layout: "fitColumns",
        columns: [],
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
    document.getElementById("getRow").addEventListener("click", function() {
        getRow({});
    });
    function addColumn() {
        var columnName = prompt("Enter Column Name");
        if (columnName) {
            var newColumn = {
                title: columnName,
                field: columnName.toLowerCase().replace(/\s+/g, "_"), // convert column name to field name
                editor:"input"
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
                if (columnName) {
                    var newColumn = {
                        title: columnName,
                        field: columnName.toLowerCase().replace(/\s+/g, "_"),
                        hozAlign: "right",
                        sorter: "number",
                        width: 150,
                        resizable: true,
                        editor:"input"
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
                row_data:rowData
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
    function getRow()
    {
        var row = table.getData();
        console.log(row);
    }
    function addRow() {
        console.log(table.getData().length);
        var newRowData = {
            id:  table.getData().length + 1, // generate a new unique ID for the row
        };
        table.addRow(newRowData);
    }
</script>
