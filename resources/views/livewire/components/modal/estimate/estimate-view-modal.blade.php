<div>
    <x-modal max-width="" blur wire:model.defer="viewModal">
        <x-card>
            {{-- <div class="modal-content"> --}}
            {{-- <div class="p-0 modal-body"> --}}
            <div class="p-0 text-center" id="printContent">
                <x-lucide-clipboard-list class="w-10 h-12 mx-auto text-success print-icon" />
                <div class="mt-5 text-3xl">Details of Estimate No : {{ $estimate_id }}</div>
                <div class="mt-2 text-slate-500"> {{ $estimateDescription }} </div>
                <div class="mt-2 text-slate-500"> </div>
                <div>
                    <table class="table mt-2 table-report">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap" style="padding-right:4rem;">#</th>
                                <th class="whitespace-nowrap">ITEM
                                    NUMBER</th>
                                <th class="whitespace-nowrap">ITEM
                                    NAME</th>
                                <th class="whitespace-nowrap" style="width:40%;text-align:center;">
                                    DESCRIPTION</th>
                                <th class="whitespace-nowrap" style="text-align:center;">QUANTITY
                                </th>
                                <th class="whitespace-nowrap" style="text-align:center;">UNIT NAME
                                </th>
                                <th class="whitespace-nowrap" style="text-align:right;">UNIT
                                    PRICE</th>
                                <th class="whitespace-nowrap" style="text-align:center;">COST</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($viewEstimates as $key => $view)
                                <tr>
                                    {{-- <td>{{ chr($view['row_id'] + 64) }}</td> --}}
                                    <td>{{ $view['row_id'] }}</td>
                                    <td>
                                        @if ($view['sor_item_number'] != '' && $view['sor_item_number'] != 0)
                                            {{-- {{ getSorItemNumber($view['sor_item_number']) }} --}}
                                            {{ $view['operation'] == 'Total' ? '' : $view['sor_item_number'] }}
                                        @elseif ($view['rate_id'] != 0)
                                            {{ $view['rate_id'] }}
                                        @elseif ($view['estimate_no'] != 0)
                                            {{-- {{ getEstimateDesc($view['estimate_no']) }} --}}
                                            {{ $view['estimate_no'] }}
                                        @elseif($view['abstract_id'] != 0)
                                            {{ $view['abstract_id'] }}
                                        @else
                                            --
                                        @endif
                                    </td>
                                    <td>
                                        @if ($view['item_name'] != '')
                                            {{ $view['item_name'] }}
                                        @endif
                                    </td>
                                    <td class="text-wrap" style="width: 40rem;text-align:justify;">
                                        @if ($view['sor_item_number'])
                                            {{-- {{ getSorItemNumberDesc($view['sor_item_number']) }} --}}
                                            @if ($view['sor_item_number'])
                                                <strong>{{ getDepartmentName($view['dept_id']) . ' / ' . getDepartmentCategoryName($view['category_id']) . ' / ' . getSorTableName($view['sor_id']) . ' / Page No: ' . getSorPageNo($view['sor_id']) . (getSorCorrigenda($view['sor_id']) != null ? ' - ' . getSorCorrigenda($view['sor_id']) : '') }}</strong>
                                                <br />
                                            @endif
                                            {{ getTableDesc($view['sor_id'], $view['item_index']) }}
                                            {{-- {{ $view['description'] }} --}}
                                        @elseif ($view['rate_id'])
                                            @php
                                                $getRateDet = getRateDescription($view['rate_id'], $view['rate']);
                                            @endphp
                                            {{ $getRateDet['description'] }}{{ $getRateDet['operation'] != '' ? ' ( ' . $getRateDet['operation'] . ' )' : '' }}
                                            {{-- {{ getRateDescription($view['rate_id'], $view['operation']) }} --}}
                                        @elseif ($view['estimate_no'] != 0)
                                            {{ getEstimateDesc($view['estimate_no']) }}
                                        @elseif($view['operation'])
                                            @if ($view['operation'] == 'Total')
                                                {{ 'Total of ( ' . str_replace('+', ' + ', $view['row_index']) . ' )' }}
                                            @else
                                                {{ str_replace('+', ' + ', $view['row_index']) }}
                                                @if ($view['comments'] != '')
                                                    {{ '( ' . $view['comments'] . ' )' }}
                                                @endif
                                            @endif
                                        @elseif($view['abstract_id'] != 0)
                                            {{ getAbstractName($view['abstract_id']) }}
                                        @else
                                            {{ $view['other_name'] }}
                                        @endif
                                    </td>
                                    <td style="text-align:center;">
                                        @if ($view['qty'] == 0)
                                        @else
                                            {{ $view['qty'] }}
                                            @if ($view['qty_analysis_data'] != '')
                                                <button class="rounded collapse-button btn btn-soft-primary btn-sm"
                                                    type="button" aria-expanded="false"
                                                    aria-controls="collapseExample_{{ $view['row_id'] }}"
                                                    onclick="toggleCollapse('{{ $view['row_id'] }}')">
                                                    <x-lucide-eye class="w-4 h-4 text-white-500" />
                                                </button>
                                            @endif
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        {{ $view['unit_id'] != 0 ? $view['unit_id'] : '' }}</td>
                                    <td style="text-align:center;">
                                        @if ($view['rate'] == 0)
                                        @else
                                            {{ round($view['rate'], 10, 2) }}
                                        @endif
                                    </td>
                                    <td style="text-align:center;">{{ round($view['total_amount'], 10, 2) }}</td>
                                </tr>
                                @if ($view['qty_analysis_data'] != '')
                                    <tr>
                                        <td colspan="8" style=" border-bottom-width: 0;">
                                            @php $serialNumber = 1; @endphp

                                            <div class="collapse" id="collapseExample_{{ $view['row_id'] }}">
                                                <div class="card card-body">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th class="whitespace-nowrap">S.no</th>
                                                                <th class="whitespace-nowrap"
                                                                    style="text-align:center;">Option</th>
                                                                <th class="whitespace-nowrap"
                                                                    style="text-align:center;">Grand total</th>
                                                                <th class="whitespace-nowrap"
                                                                    style="text-align:center;">UNIT NAME</th>
                                                                <th class="whitespace-nowrap"
                                                                    style="text-align:center;">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="metatable">
                                                            <?php
                                                            $data = json_decode($view['qty_analysis_data'], true);
                                                            if (isset($data['metadata'])) {
                                                                $metadataArray = $data['metadata'];
                                                               // dd($metadataArray);
                                                                foreach ($metadataArray as $index => $metadata) {
                                                                    ?>
                                                            <tr>
                                                                <td style="text-align:center;">A<?php echo $index + 1; ?></td>
                                                                <td style="text-align:center;"><?php echo $metadata['type']; ?></td>
                                                                <td style="text-align:center;"><?php echo $metadata['overallTotal']; ?></td>
                                                                <td style="text-align:center;"><?php echo !empty($metadata['unit']) ? $metadata['unit'] : null; ?></td>
                                                                <td style="text-align:center;">
                                                                    @if (!isset($metadata['key']))
                                                                        <button
                                                                            class="rounded collapse-button btn btn-soft-primary btn-sm"
                                                                            type="button" aria-expanded="false"
                                                                            aria-controls="collapseExample1_{{ $metadata['currentId'] }}_{{ $view['row_id'] }}"
                                                                            onclick="toggleCollapse1('{{ $metadata['currentId'] }}_{{ $view['row_id'] }}')">
                                                                            <x-lucide-eye
                                                                                class="w-4 h-4 text-white-500" />
                                                                        </button>
                                                                    @endif
                                                                </td>

                                                            </tr>
                                                            <tr class="collapse"
                                                                id="collapseExample1_{{ $metadata['currentId'] }}_{{ $view['row_id'] }}">
                                                                <td colspan="5">
                                                                    <div class="card card-body">
                                                                        <?php
                                                                        if (isset($metadata['currentId'])) {
                                                                            if(isset($metadata['type']) && $metadata['type'] == "other") {
                                                                        ?>
                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                                <tr class="thead">
                                                                                    <th>Sl.no</th>
                                                                                    <th>Member</th>
                                                                                    <th>Number</th>
                                                                                    <th>Height</th>
                                                                                    <th>Breadth</th>
                                                                                    <th>Length</th>
                                                                                    <th>Unit</th>
                                                                                    <th>Total</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                $data = json_decode($view['qty_analysis_data'], true);
                                                                                $metadataArrayDetails = $data[$metadata['currentId']];
                                                                                $serialno= 1;
                                                                                foreach ($metadataArrayDetails as $index => $metadataDetails) {
                                                                                    ?>
                                                                                <tr>
                                                                                    <td style="text-align:center;">
                                                                                        <?php echo $serialno; ?></td>
                                                                                    <td style="text-align:center;">
                                                                                        <?php echo isset($metadataDetails['member']) ? $metadataDetails['member'] : ''; ?></td>
                                                                                    <td style="text-align:center;">
                                                                                        <?php echo isset($metadataDetails['number']) ? $metadataDetails['number'] : ''; ?></td>
                                                                                    <td style="text-align:center;">
                                                                                        <?php echo isset($metadataDetails['height']) ? $metadataDetails['height'] : ''; ?></td>
                                                                                    <td style="text-align:center;">
                                                                                        <?php echo isset($metadataDetails['breadth']) ? $metadataDetails['breadth'] : ''; ?></td>
                                                                                    <td style="text-align:center;">
                                                                                        <?php echo isset($metadataDetails['length']) ? $metadataDetails['length'] : ''; ?></td>
                                                                                    <td style="text-align:center;">
                                                                                        <?php echo isset($metadataDetails['unit']) ? $metadataDetails['unit'] : ''; ?></td>
                                                                                    <td style="text-align:center;">
                                                                                        <?php echo isset($metadataDetails['total']) ? $metadataDetails['total'] : ''; ?></td>
                                                                                </tr>
                                                                                <?php
                                                                                    $serialno++;
                                                                                }
                                                                                ?>
                                                                            </tbody>
                                                                        </table>
                                                                        <?php }
                                                                        else {
                                                                        $columnHeadings = array(
                                                                        'type' => 'Rule',
                                                                        'unit' => 'Unit',
                                                                        'parent_id' => 'Row',
                                                                        'length' => 'Length',
                                                                        'width' => 'Breadth',
                                                                        'height' => 'Height',
                                                                        'remarks' => 'Remarks',
                                                                        'Input_for_W' => 'Input W',
                                                                        'Input_for_def_Y' => 'No of Y',
                                                                        'Input_for_Y1' => 'Y1',
                                                                        'Input_for_Y2' => 'Y2',
                                                                        'Input_for_Y3' => 'Y3',
                                                                        'Input_for_Y4' => 'Y4',
                                                                        'overallTotal' => 'Total'
                                                                    );

                                                                    $ruledata = json_decode($view['qty_analysis_data'], true);
                                                                    $metadataArrayDetailss = $ruledata[$metadata['currentId']];
                                                                    $metadataArrayruleDetails = $metadataArrayDetailss['input_values'];
                                                                    $keysToExclude = ['currentId', 'editEstimate_id', 'btntype', 'exp', 'key','parent_id'];
                                                                    ?>
                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                                <tr class="thead">
                                                                                    <th>Sl.no</th>
                                                                                    <?php foreach ($columnHeadings as $headkey => $heading): ?>
                                                                                    <?php if (!in_array($headkey, $keysToExclude) && isset($metadataArrayruleDetails[$headkey])): ?>
                                                                                    <th><?php echo $heading; ?></th>
                                                                                    <?php endif; ?>
                                                                                    <?php endforeach; ?>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="text-align:center;">1
                                                                                    </td> <!-- Serial Number -->
                                                                                    <?php foreach ($columnHeadings as $headkey => $heading): ?>
                                                                                    <?php if (!in_array($headkey, $keysToExclude) && isset($metadataArrayruleDetails[$headkey])): ?>
                                                                                    <td style="text-align:center;">
                                                                                        <?php echo $metadataArrayruleDetails[$headkey]; ?>
                                                                                    </td>
                                                                                    <?php endif; ?>
                                                                                    <?php endforeach; ?>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                        <?php }
                                                                        ?>
                                                                    </div>

                                                                </td>
                                                            </tr>
                                                            <?php
                                                                }
                                                            }}
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>


                                        </td>
                                    </tr>
                                @endif
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
                        <x-button class="btn btn-soft-danger px-3 py-2.5 rounded" flat label="Cancel"
                            x-on:click="close" />
                    </div>
                    {{-- <div class="flex float-right">
                        <button wire:click="download({{ $estimate_id }})" class="btn btn-soft-info">
                            <x-lucide-download class="w-4 h-4 text-gray-500" /> Download
                        </button>
                    </div> --}}
                    <div class="flex float-right">
                        <button class="btn btn-soft-info" onclick="printContent()">
                            <x-lucide-printer class="w-4 h-4 text-gray-500" /> Print
                        </button>
                    </div>
                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>
<script>
    function toggleCollapse(key) {
        var collapseExample = document.getElementById('collapseExample_' + key);
        var ariaExpanded = collapseExample.getAttribute('aria-expanded');

        if (ariaExpanded === 'true') {
            collapseExample.classList.remove('show');
            collapseExample.setAttribute('aria-expanded', 'false');
        } else {
            collapseExample.classList.add('show');
            collapseExample.setAttribute('aria-expanded', 'true');
        }
    }

    function toggleCollapse1(currentId) {
        //alert(currentId);
        var collapseExample = document.getElementById('collapseExample1_' + currentId);
        var ariaExpanded = collapseExample.getAttribute('aria-expanded');

        if (ariaExpanded === 'true') {
            collapseExample.classList.remove('show');
            collapseExample.setAttribute('aria-expanded', 'false');
        } else {
            collapseExample.classList.add('show');
            collapseExample.setAttribute('aria-expanded', 'true');

        }
    }

    function printContent() {

        var printWindow = window.open('', '_blank', 'width=900,height=800');

        printWindow.document.write('<html><head><title>https://wbupms.wb.gov.in</title></head><body>');

        // Clone the content and append it to the new window
        var contentToPrint = document.getElementById('printContent').cloneNode(true);
        // Remove all buttons from the cloned content
        var buttons = contentToPrint.querySelectorAll('button');
        buttons.forEach(function(button) {
            button.remove();
        });
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
