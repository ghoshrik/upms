<div>
    <style>
    .custom-modal .modal-header .close {
        /* margin-top: -5px; */
        margin-top: 20px;
        position: absolute;
        /* right: -8px; */
        right: 21px;
        background-color: #000;
        opacity: 1;
        color: #fff;
        height: 25px;
        width: 25px;
        border-radius: 50%;
        top: -8px;
        z-index: 1;
    }
	.tabulator-cell .tabulator-edit-text {
            height: auto;
            /* Allow the textarea to adjust its height based on content */
            white-space: normal;
            /* Allow text wrapping */
        }
</style>
    @if ($show)
        <div class="modal fade custom-modal" id="{{ $modalName }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-fullscreen" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ $title }}</h5>
                        <button type="button" class="close" id="closeBtn" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div id="example-table"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="closeBtne" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.getElementById("closeBtn").addEventListener("click", function() {
                closeModal();
            });
	    document.getElementById("closeBtne").addEventListener("click", function() {
                closeModal();
            });

            function closeModal() {
                $('#' + @json($modalName)).modal('hide');
                window.Livewire.emit('closeModal');
            }
            $(document).ready(function() {
                $("#" + @json($modalName)).modal({
                    backdrop: "static",
                    keyboard: false
                });
                var headerData = @json($headerData);
                var rowData = @json($rowData);
		headerData.forEach(function(column) {
                    if (column.columns) {
                        column.columns.forEach(function(subColumn) {
                            delete subColumn.editor;

                            // Add textarea formatter and variableHeight option
                            subColumn.formatter = "textarea";
                            subColumn.formatter = "input";
                            subColumn.variableHeight = true;
                        });
                    } else {
                        delete column.editor;

                        // Add textarea formatter and variableHeight option
                        column.formatter = "textarea";
                        //column.formatter = "input";
                        column.variableHeight = true;
                    }
                });
                var delay = 1500; // Delay time in milliseconds

                var delayPromise = new Promise(function(resolve) {
                    setTimeout(function() {
                        resolve();
                    }, delay);
                });

                delayPromise.then(function() {
                    var table = new Tabulator("#example-table", {
                        height: "auto",
			columnVertAlign: "bottom",
                        layout: "fitDataFill",
			columnHeaderVertAlign: "center",
                        columns: headerData,
                        data: rowData,
                        dataTree: true, // Enable the dataTree module
                        dataTreeStartExpanded: true, // Optional: Expand all rows by default
                        dataTreeChildField: "_subrow", // Specify the field name for subrows
                        dataTreeChildIndent: 10, // Optional: Adjust the indentation level of subrows
			variableHeight: true,
                        variableWidth: true,
                    });



                    $("#" + @json($modalName)).modal("show");
                });
            });
        </script>
    @endif
</div>
