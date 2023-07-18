<div>
    <div id="example-table"></div>
</div>
<button id="addRow" class="btn btn-primary">Add Row</button>
{{-- <button id="getRow" class="btn btn-secondary">Get Row</button> --}}
<button id="updateData" class="btn btn-success">Update Data</button>
<script>
    $(document).ready(function() {
        var headerData = @json($header_data);
        var rowdata = @json($row_data);
        var tableId = @json($selectedId);
        headerData.forEach(function(column) {
            var fun;
            delete column.editor;
            if(column.isClick){
                column.isClick = eval('(' + column.isClick + ')');
                fun = column.isClick;
            }
            if(column.cellClick){
                column.cellClick = eval('(' + column.isClick + ')');
                fun = column.cellClick;
            }
            if (typeof fun === "function") {
                column.cellClick = function(e, cell) {
                    // Overwritten cellClick function
                    var rowData = cell.getRow().getData();
                    alert("Cell clicked. Value: " + cell.getRow().getIndex() + "-" + cell
                    .getValue()+" - "+rowData['description_of_items']);
                    // Add your custom code or logic here
                };
            }
            if (column.columns) {
                column.columns.forEach(function(subColumn) {
                    var subFun;
                    delete subColumn.editor;
                    if(subColumn.isClick){
                        subFun = subColumn.isClick = eval('(' + subColumn.isClick + ')');
                    }
                    if(subColumn.cellClick){
                        subFun = subColumn.cellClick = eval('(' + subColumn.cellClick + ')');
                    }
                    if (typeof subFun === "function") {
                        subColumn.cellClick = function(e, cell) {
                            // Overwritten cellClick function
                            // console.log(cell);
                            var subrowIndex = cell.getRow().getIndex();
                            var rowData = cell.getRow().getData();
                            alert("Cell clicked. Value: " + subrowIndex + "-" +
                                cell.getValue()+" - "+rowData['description_of_items']);
                            // Add your custom code or logic here
                        };
                    }
                });
            }
        });
        var table = new Tabulator("#example-table", {
            height: "500",
            layout: "fitColumns",
            columns: headerData,
            data: rowdata,
            dataTree: true, // Enable the dataTree module
            dataTreeStartExpanded: true, // Optional: Expand all rows by default
            dataTreeChildField: "_subrow", // Specify the field name for subrows
            dataTreeChildIndent: 10, // Optional: Adjust the indentation level of subrows
        });

        // table.on("rowClick", function(e, row) {
        //     alert("Row " + row.getIndex() + " Clicked!!!!")
        // });

        document.getElementById("addRow").addEventListener("click", function() {
            addRow({});
        });
        // document.getElementById("getRow").addEventListener("click", function() {
        //     getRow({});
        // });
        document.getElementById("updateData").addEventListener("click", function() {
            updateRow({});
        });

        function getRow() {
            var row = table.getData();
            console.log(row);
        }

        function addRow() {

            var newRowData = {
                id: table.getData().length + 1, // generate a new unique ID for the row
            };
            table.addRow(newRowData);
        }

        function updateRow() {
            // Send an AJAX request to update the row data
            var rowData = table.getData();

            $.ajax({
                url: '/update-row-data',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: 'application/json',
                data: JSON.stringify({
                    tableId: tableId,
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
    });
</script>
