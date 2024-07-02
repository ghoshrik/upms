<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 col-lg-4 col-sm-12 mb-2">
                    <label for="table No">Table No <span style="color:red;">*</span></label>
                    <input type="text" class="form-control" placeholder="Table No" wire:model.defer="field.tableNo"
                        readonly />
                </div>
                <div class="col-md-12 col-lg-5 col-sm-12 mb-2">
                    <label for="table Title">Table Title <span style="color:red;">*</span></label>
                    <input type="text" class="form-control" placeholder="Table Title" wire:model.defer="field.title"
                        readonly />
                </div>
                <div class="col-md-12 col-lg-3 col-sm-12 mb-2">
                    <label for="table Title" style="font-width:bold;">Department Category </label>
                    <input type="text" class="form-control" wire:model.defer="field.dept_category.dept_category_name"
                        readonly />
                </div>
                <div class="col-md-12 col-lg-2 col-sm-12 mb-2">
                    <label for="table Title" style="font-width:bold;">Volume No </label>
                    <input type="text" class="form-control" wire:model.defer="field.volumeNo" readonly />
                </div>
                <div class="col-md-12 col-lg-2 col-sm-12 mb-2">
                    <label for="table Title" style="font-width:bold;">Page No <span style="color:red;">*</span></label>
                    <input type="text" class="form-control" wire:model.defer="field.pageNo" readonly />
                </div>
                <div class="col-md-12 col-lg-2 col-sm-12 mb-2">
                    <label for="table Title" style="font-width:bold;">Publish Date <span style="color:red;">*</span></label>
                    <input type="text" class="form-control" wire:model.defer="field.publishDate" readonly />
                </div>
		@if($field['corrigenda']!=null)
		<div class="col-md-12 col-lg-6 col-sm-12 mb-2">
                    <label for="table Title" style="font-width:bold;">No of Corrigenda </label>
                    <input class="form-control" wire:model.defer="field.corrigenda" readonly />
                </div>
		@endif
            </div>
        </div>
    </div>

    <div id="loadingModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
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
    <div id="loaderoverlay"></div>

    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-3">
            <button id="updateData" class="btn btn-success rounded btn-sm extUpdTable float-end ">Update
                Data</button>
            <button id="pdfDownload" class="btn btn-secondary rounded btn-sm" disabled>
                <x-lucide-file-text class="w-4 h-4 text-gray-500" /> PDF
            </button>
            <button id="download-xlsx" class="btn btn-secondary rounded btn-sm">
                <x-lucide-sheet class="w-4 h-4 text-gray-500" /> Excel
            </button>
        </div>
        <div class="col-md-12 col-lg-12 col-sm-3">
            <div class="mt-2 mb-2" id="tabulator_table"></div>
        </div>
        <div class="col-md-12 col-lg-12 col-sm-3 mb-3">
            <label for="Note" style="font-weight:bold;">Note </label>
            <textarea class="form-control" wire:model.defer="field.Note" rows="5" cols="5" id="tbl_note" placeholder="Short Note "
                ></textarea>
        </div>
    </div>
    <script>
	
	/* loading Screen */
    	const LoadingModel = document.getElementById("loadingModal");
    	const LoadverOverlay = document.getElementById("loaderoverlay");

    /* loading Screen */

        /*headData custom height and weight define*/

        const headerData = @json($field['headerData']);
        
        //console.log(headerData);
   	//console.log(@json($field['selectId']));
        headerData.forEach(function(column) {

            if (column.columns)
            {
            column.columns.forEach(function(subColumn)
            {
                subColumn.formatter = "textarea";
		subColumn.formatter = "number";
                subColumn.variableHeight = true;
            });
        }
        else
        {
            column.formatter = "textarea";
	    column.formatter = "number";
            column.variableHeight = true;
        }
        });

        /*Table view mode */
        var table = new Tabulator("#tabulator_table", {
            height: "auto",
            columnVertAlign: "bottom",
            scrollVertical: "column",
            // layout: "fitColumns",
            layout: "fitDataFill",

            // responsiveLayout: true,
            columns: headerData,
            columnHeaderVertAlign: "center",
            //autoColumns: true,
            data:  @json($rowData),
            headerClick: true,
            // selectable: true,
            dataTree: true, // Enable the dataTree module
            dataTreeStartExpanded: true, // Optional: Expand all rows by default
            dataTreeChildField: "_subrow", // Specify the field name for subrows
            dataTreeChildIndent: 10, // Optional: Adjust the indentation level of subrows
            variableHeight: true,
            variableWidth: true,
            downloadDataFormatter: true,
            downloadComplete: true,
            downloadConfig: {
                columnHeaders: true,
                columnGroups: true,
                rowGroups: true,
                columnCalcs: true,
                dataTree: true,
            },
	    rowFormatter:function(row)
	    {
	        const rowData = row.getData();
		if(rowData.background_color=== "blue")
		{
		    row.getElement().style.fontWeight = "bold";
		}
            },
	    cellFormatter: function(cell) 
	   {
		let cellData = cell.getValue();
		console.log(cellData);
		if(cellData==="DELETED")
		{
		    cell.getElement().style.fontWeight = "bold";
		}
		
	   }
        });

	function base64Encode(rowData)
	{
    		const jsonStr = JSON.stringify(rowData.getData());
    		//console.log(jsonStr);
		const encoder = new TextEncoder();
		const jsonDataAsBytes = encoder.encode(jsonStr);
		const base64EncodedData = btoa(String.fromCharCode(...jsonDataAsBytes));
	        return base64EncodedData;
         }
	 const updbtn = document.getElementById("updateData");

	 updbtn.addEventListener("click", function() {
	     updbtn.disabled = true;
	     LoadverOverlay.style.display = "block";
             LoadingModel.style.display = "block";
             table.deleteColumn("addBtn");
             table.deleteColumn("delBtn");
        	console.log(document.getElementById('tbl_note').value);
	     $.ajax({
        	url: "{{ route('update-row-data') }}",
	        type: 'POST',
        	headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        	},
	        contentType: 'application/json',
        	data: JSON.stringify({
		    tableId: @json($field['selectId']),
	            row_data: base64Encode(table),
        	    note:document.getElementById('tbl_note').value
        	}),
	        success: function(response) {
        	    if (response.status === true) {
                	updbtn.disabled = false;
	                LoadverOverlay.style.display = "none";
        	        LoadingModel.style.display = "none";
                	window.$wireui.notify({
	                    description: response.message,
        	            icon: 'success'
                	});
	            }
        	},
        	error: function(error) {
            		console.error('Error storing data:', error);
            		if(error)
            		{
				updbtn.disabled = false;
                		LoadverOverlay.style.display = "none";
                		LoadingModel.style.display = "none";
                		window.$wireui.notify({
                    			description: "Store data error",
                    			icon: 'error'
                		});
            		}
        	}
    		});
	 });
	 document.getElementById("download-xlsx").addEventListener("click", function() {
        	table.deleteColumn("id");
        	table.download("xlsx", @json($field['title']) + ".xlsx", {
            	sheetName: "title"
        	});
    	});
	

    </script>
</div>