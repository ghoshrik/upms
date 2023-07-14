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
        var table = new Tabulator("#example-table", {
            height: "311px",
            layout: "fitColumns",
            columns: headerData,
            data: rowdata
        });
        document.getElementById("addRow").addEventListener("click", function() {
            addRow({});
        });
        document.getElementById("getRow").addEventListener("click", function() {
            getRow({});
        });
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
