<div>
    <div class="conatiner-fluid content-inner py-0" x-data="{
        ListModal: false,
        modalData: [],
        {{-- pdfData: @entangle('tableContent'), --}}
        tableLists: @entangle('tableData'),
        ViewModel: function(id) {
            if (!this.ListModal) {
                this.ListModal = true;
                {{-- console.log(id, this.id); --}}
                {{-- console.log(this.pdfData.project_desc); --}}
    
                Livewire.emit('abstructData', id);
                Livewire.on('abstructs', (data) => {
                    this.pdfData = data;
                    console.log(this.pdfData.project_desc);
                });
    
                {{-- if (id) { --}}
                {{-- this.id = id; --}}
    
                {{-- const apiUrl = '{{ route('abstructsCosts') }}';
                    const params = {
                        costsId: this.id,
                    };
                    const urlWithParams = new URL(apiUrl);
                    urlWithParams.search = new URLSearchParams(params).toString();
                    fetch(urlWithParams).then(response =>
                            response.json())
                        .then(data => {
                            this.modalData = data;
                            console.log(this.modalData);

                        })
                        .catch(error => {
                            console.error('Error fetching department:', error);
                        }); --}}
                {{-- } --}}
            }
        },
        renderItems: function() {
    
        },
        PdfView: function(id) {
            Livewire.emit('abstractData', id);
            Livewire.on('abstructs', (data) => {
                this.pdfData = data;
                this.pdfData['tableHeader'].pop();
                var headerHead = this.pdfData['tableHeader'].map(header => header.title);
                var bodyRow = this.pdfData['tableData'].map(item => {
                    return this.pdfData['tableHeader'].map(header => item[header.field]);
                });
    
                var cleanedTableData = this.pdfData['tableData'].map(item => {
                    const { ACTIONS, ...rest } = item;
                    return rest;
                });
    
                {{-- console.log(headerHead);
                console.log(cleanedTableData);
                console.log(bodyRow); --}}
    
                const doc = new jsPDF({
                    orientation: 'portrait', // Set orientation to landscape
                    unit: 'pt' // Use pixels as the unit for width and height
    
                });
    
                var pageSize = doc.internal.pageSize;
    
    
                //description
                const descriptionremovehtml = this.pdfData['project_desc'];
                const headerTitle = descriptionremovehtml.replace(/<[^>]*>/g, '');
    
    
                doc.setLineWidth(2);
                // Calculate the width of the text
                let text = 'General abstruct of cost';
                var textWidth = doc.getTextWidth(text);
    
                // Calculate the x position to center the text
                var xPosition = (doc.internal.pageSize.width - textWidth) / 2;
    
                // Add the content above the table
                doc.setFontSize(15);
                doc.text(text, xPosition, 13);
    
    
                doc.setFontSize(13);
                var pageWidth = pageSize.width ? pageSize.width : pageSize.getWidth();
                var splitTitle = doc.splitTextToSize(headerTitle, pageWidth - 40);
                doc.text(splitTitle, 30, 30);
    
                var textHeight = doc.getTextDimensions(splitTitle).h;
                var startY = textHeight + 20;
    
    
    
    
                doc.autoTable({
                    head: [headerHead],
                    body: bodyRow,
                    styles: {
                        fillColor: [255, 255, 255],
                        textColor: [0, 0, 0],
                        lineColor: [0, 0, 0], // Specify the border color as black [R, G, B]
                        lineWidth: 0.5, // Set border line width
                        fontSize: 8, // Reduce the font size
                        valign: 'middle',
                        overflow: 'linebreak',
                        tableWidth: 'auto',
                    },
                    columnStyles: {
                        2: {
                            halign: 'right',
                            tableWidth: 100,
                        }
                    },
                    {{-- bodyStyles: {
                        cellPadding: { top: 1, right: 2, bottom: 1, left: 2 },
                    }, --}}
                    margin: {
                        top: 30,
                        bottom: 20,
                    },
                    didDrawPage: function(data) {
                        //footer
                        var str = 'Page ' + doc.internal.getNumberOfPages();
                        if (typeof doc.putTotalPages === 'function') {
                            str = str + ' of ' + doc.internal.getNumberOfPages();
                        }
                        doc.setFontSize(10);
                        var pageSize = doc.internal.pageSize;
                        var pageHeight = pageSize.height ? pageSize.height : pageSize.getHeight();
    
    
    
                        {{-- var footerTextWidth = doc.getStringUnitWidth(footerText) * doc.internal.getFontSize() / doc.internal.scaleFactor;
                        var footerX = (pageSize.width - footerTextWidth) / 2;
                        var footerY = pageSize.height - 10; --}}
                        doc.text(str, data.settings.margin.left, pageHeight - 10);
                    },
                    startY: startY + 10, // Start printing the table from y-position 20
                    pageBreak: 'auto',
    
                });
    
    
                // Get the end position of the table
                let finalY = doc.autoTable.previous.finalY || startY;
    
                // Add the final text with a box
                const finalText = '(' + convertNumberToWords(this.pdfData['total_amount']) + ')';
                const textX = 40;
                const textY = finalY + 20; // Adjust the Y position to be below the table
                const boxWidth = pageWidth - 80;
                const boxHeight = doc.getTextDimensions(finalText).h + 20; // Adjust the height of the box as necessary
    
                // Draw the box
                doc.setDrawColor(0); // Black color
                doc.setLineWidth(1);
                doc.rect(textX, textY, boxWidth, boxHeight);
    
                // Add the text inside the box
                doc.setFontSize(10);
                doc.setTextColor(0); // Black color
                const splitFinalText = doc.splitTextToSize(finalText, boxWidth - 20); // Wrap the text inside the box
    
                doc.text(splitFinalText, textX + 10, textY + 10); // Adjust the position within the box
                doc.save('table-data.pdf');
    
    
    
                const filename = 'abstracts.pdf';
                // Generate the PDF and get its URL
                const pdfData = doc.output('blob');
                const pdfUrl = URL.createObjectURL(pdfData);
    
                // Open the generated PDF in a new tab
                const newTab = window.open(pdfUrl, '_blank');
    
                newTab.onload = function() {
                    newTab.document.title = filename;
                };
                // Optionally revoke the object URL after use
                URL.revokeObjectURL(blobUrl);
                rows.forEach(row => {
                    const lastCell = row.lastElementChild;
                    if (lastCell) {
                        lastCell.style.display = ''; // Reset display property
                    }
                });
    
            });
    
        },
        closeModal: function() {
            this.ListModal = false;
            const modalBody = this.$refs.modalBody;
            modalBody.innerHTML = '';
        },
        tableFilterData: function() {
            console.log('data', this.tableLists);
            console.log(this.pdfData);
        }
    
    }">
        <div class="iq-navbar-header" style="height: 124px;">
            @if ($errorMessage != null)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span> {{ $errorMessage }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="container-fluid iq-container">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 gap-3">
                    <div class="d-flex flex-column">
                        <h3 class="text-dark">{{ $title }}</h3>
                        <p class="text-primary mb-0">{{ $subTitle }}</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center rounded flex-wrap gap-3">
                        @if (!$isFromOpen)
                            <button wire:click="fromEntryControl('create')" class="btn btn-primary rounded-pill "
                                x-transition:enter.duration.600ms x-transition:leave.duration.10ms>
                                <span class="btn-inner">
                                    <x-lucide-plus class="w-4 h-4 text-gray-500" /> Create
                                </span>
                            </button>
                        @else
                            <button wire:click="fromEntryControl" class="btn btn-danger rounded-pill "
                                x-transition:enter.duration.100ms x-transition:leave.duration.100ms>
                                <span class="btn-inner">
                                    <x-lucide-x class="w-4 h-4 text-gray-500" /> Close
                                </span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div>
            @if ($isFromOpen && $openedFormType == 'create')
                <livewire:abstruct-costs.create-abstruct />
            @else
                <div class="card">
                    <div class="card-body">
                        @if (!empty($tableData))
                            <div class="table-left-bordered table-responsive mt-4">
                                <table x-ref='Abstrcuts' class="table mb-0" role="grid">
                                    <thead>
                                        <tr class="bg-white">
                                            <th scope="col" width="8%">
                                                {{ trans('cruds.abstract.fields.id_helper') }}</th>
                                            <th scope="col" width="50%">
                                                {{ trans('cruds.abstract.fields.project_desc') }}
                                            </th>
                                            <th scope="col" width="20%">
                                                {{ trans('cruds.abstract.fields.total_amount') }}
                                            </th>
                                            <th scope="col" width="20%">
                                                {{ trans('cruds.abstract.fields.actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($tableData as $data)
                                            <tr>
                                                <td class="text-wrap">{{ $loop->iteration }}</td>
                                                <td class="text-wrap">{!! $data->project_desc !!}</td>
                                                <td class="text-wrap">{{ number_format($data->total_amount, 2) }}
                                                </td>
                                                <td class="text-wrap">
                                                    <x-action-button class="btn-soft-primary"
                                                        wire:click="$emit('RowAbstractData',{{ $data->id }})">
                                                        <x-lucide-eye class="w-4 h-4 text-gray-500" />
                                                        {{ trans('global.view_btn') }}
                                                    </x-action-button>
                                                    <x-action-button class="btn-soft-secondary"
                                                        x-on:click="PdfView({{ $data->id }})">
                                                        <x-lucide-file class="w-4 h-4 text-gray-500" />
                                                        {{ trans('global.export.pdf') }}
                                                    </x-action-button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">
                                                    <strong>{{ trans('global.table_data_msg') }}</strong>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
                <livewire:abstruct-costs.abstract-model-costs />
            @endif
        </div>
    </div>
</div>
