<div>
    <x-modal max-width="5xl" blur wire:model.defer="viewModal">
        <x-card>
            {{-- <div class="modal-content"> --}}
            {{-- <div class="p-0 modal-body"> --}}
            <div class="p-0 text-center" id="printContent">
                <x-lucide-clipboard-list class="w-10 h-12 mx-auto text-success print-icon" />
                <div class="mt-5 text-3xl">Details of Rate No : {{ $rate_id }}</div>
                <div class="mt-2 text-slate-500"> {{ $rateDescription }} </div>
                <div>
                    <table class="table mt-2 table-report">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap" style="padding-right:4rem;">#</th>
                                <th class="whitespace-nowrap">ITEM
                                    NUMBER</th>
                                <th class="whitespace-nowrap" style="width:40%;text-align:center;">
                                    DESCRIPTION</th>

                                <th class="whitespace-nowrap" style="text-align:center;">QUANTITY
                                </th>
                                <th class="whitespace-nowrap" style="text-align:right;">UNIT
                                    PRICE</th>
                                <th class="whitespace-nowrap" style="text-align:center;">COST</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($viewEstimates as $view)
                                <tr>
                                    <td>{{ chr($view['row_id'] + 64) }}</td>
                                    <td>
                                        @if ($view['sor_item_number'])
                                            {{-- {{ getSorItemNumber($view['sor_item_number']) }} --}}
                                            {{ $view['operation'] == 'Total' ? '' : $view['sor_item_number'] }}
                                        @elseif ($view['rate_no'])
                                            {{ $view['rate_no'] }}
                                        @endif
                                    </td>
                                    <td class="text-wrap" style="width: 40rem">
                                        @if ($view['sor_item_number'])
                                            {{-- {{ getSorItemNumberDesc($view['sor_item_number']) }} --}}
                                            {{ $view['description'] }}
                                        @elseif ($view['rate_no'])
                                            {{ getRateDescription($view['rate_no'], $view['rate']) }}
                                        @elseif($view['operation'])
                                            @if ($view['operation'] == 'Total')
                                                {{ 'Total of ( ' . $view['row_index'] . ' )' }}
                                            @else
                                                {{ $view['row_index'] }}
                                                @if ($view['comments'] != '')
                                                    {{ '( ' . $view['comments'] . ' )' }}
                                                @endif
                                            @endif
                                        @else
                                            {{ $view['other_name'] }}
                                        @endif
                                    </td>
                                    <td style="text-align:center;">
                                        @if ($view['qty'] == 0)
                                        @else
                                            {{ $view['qty'] }}
                                        @endif
                                    </td>
                                    <td style="text-align:center;">
                                        @if ($view['rate'] == 0)
                                        @else
                                            {{ $view['rate'] }}
                                        @endif
                                    </td>
                                    <td style="text-align:center;">{{ $view['total_amount'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
            {{-- </div> --}}
            {{-- </div> --}}
            <x-slot name="footer">
                <div class="flex justify-between">
                    <div class="flex float-left">
                        <x-button class="btn btn-soft-danger" flat label="Cancel" x-on:click="close" />
                    </div>
                    {{-- <div class="flex float-right">
                        <button wire:click="download({{ $rate_id }})" class="btn btn-soft-info">
                            <x-lucide-download class="w-4 h-4 text-gray-500" /> Download
                        </button>
                    </div> --}}
                    <div class="flex float-right">
                        <button class="btn btn-soft-info" onclick="printContent()">
                            <x-lucide-printer class="w-4 h-4 text-gray-500" /> Print
                        </button>
                    </div>
                </div>
                {{-- </div> --}}
            </x-slot>
        </x-card>
    </x-modal>
</div>
<script>
    function printContent() {
        var printWindow = window.open('', '_blank', 'width=900,height=800');

        printWindow.document.write('<html><head><title>https://wbupms.wb.gov.in</title></head><body>');

        // Clone the content and append it to the new window
        var contentToPrint = document.getElementById('printContent').cloneNode(true);
        printWindow.document.body.appendChild(contentToPrint);

        // Add styles for print inside the script
        var style = printWindow.document.createElement('style');
        style.textContent = `
            @media print {
                .print-icon {
                    width: 50px;
                    height: 50px;
                    display: block;
                    margin: 0 auto; /* Center-align the icon */
                }

                /* Add your print styles here */
                #printContent {
                    /* Add styles specific to the print version of #printContent */
                }
                /* Table styles */
                table {
                    border-collapse: collapse;
                    width: 100%;
                }

                th, td {
                    border: 1px solid #000; /* Add borders to all sides of table cells */
                    /* padding: 8px; */
                    text-align: left;
                }

                th {
                    background-color: #f2f2f2; /* Set background color for table header */
                }
            }
        `;
        printWindow.document.head.appendChild(style);

        printWindow.document.write('</body></html>');
        printWindow.document.close();

        // Wait for the content to be fully loaded before printing
        printWindow.onload = function() {
            printWindow.print();
            printWindow.onafterprint = function() {
                printWindow.close();
            };
        };
    }
</script>
