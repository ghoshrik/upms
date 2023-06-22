<div>
    <x-modal max-width="5xl" blur wire:model.defer="editEstimateModal">
        <x-card>
            {{-- <div class="modal-content"> --}}
            {{-- <div class="p-0 modal-body"> --}}
            <div class="p-0 text-center">
                <x-lucide-clipboard-list class="w-10 h-12 mx-auto text-success" />
                <div class="mt-5 text-3xl">Details of Estimate No : </div>
                <div class="mt-2 text-slate-500"> </div>
                <div>
                    <table class="table mt-2 table-report">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap" style="width:5%;">#</th>
                                <th class="whitespace-nowrap" style="width:5%;">ITEM
                                    NUMBER</th>
                                <th class="whitespace-nowrap" style="width:30%;">
                                    DESCRIPTION</th>

                                <th class="whitespace-nowrap" style="width:5%;">QUANTITY
                                </th>
                                <th class="whitespace-nowrap" style="width:5%;">UNIT
                                    PRICE</th>
                                <th class="whitespace-nowrap" style="width:15%;">COST</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($editEstimateRow)
                            @if ($editEstimateRow!=null)
                                {{-- @dd($editEstimateRow) --}}
                                {{-- @foreach ($editEstimateRow) --}}
                                    <tr>
                                        <td>{{ chr($editEstimateRow['row_id'] + 64) }}</td>
                                        <td class="text-wrap">
                                            @if ($editEstimateRow['sor_item_number'])
                                                {{ getSorItemNumber($editEstimateRow['sor_item_number']) }}
                                            @elseif ($editEstimateRow['estimate_no'])
                                                {{ $editEstimateRow['estimate_no'] }}
                                            @endif
                                        </td>
                                        <td class="text-wrap">
                                            @if ($editEstimateRow['sor_item_number'])
                                                {{ getSorItemNumberDesc($editEstimateRow['sor_item_number']) }}
                                            @elseif ($editEstimateRow['estimate_no'])
                                                {{ getEstimateDescription($editEstimateRow['estimate_no']) }}
                                            @elseif($editEstimateRow['operation'])
                                                @if ($editEstimateRow['operation'] == 'Total')
                                                    {{ 'Total of ( ' . $editEstimateRow['row_index'] . ' )' }}
                                                @else
                                                    {{ $editEstimateRow['row_index'] }}
                                                    @if ($editEstimateRow['comments'] != '')
                                                        {{ '( ' . $editEstimateRow['comments'] . ' )' }}
                                                    @endif
                                                @endif  
                                            @else
                                                {{ $editEstimateRow['other_name'] }}
                                            @endif
                                        </td>
                                        <td>
                                                @if ($editEstimateRow['item_name'] == "SOR" || $editEstimateRow['item_name']== "Other" || $editEstimateRow['item_name']== "Estimate")
                                                    <x-input wire:key="sor_qty" wire:model.defer="qty" wire:keyup="calculateValue" />
                                                @else
                                                    {{ $editEstimateRow['qty'] }}
                                                @endif
                                        </td>
                                        <td>
                                            @if ($editEstimateRow['item_name'] == "SOR")
                                           
                                                <x-input wire:key="sor_rate" placeholder="{{ $editEstimateRow['rate'] }}"  wire:model.defer="" disabled/>
                                            @elseif ($editEstimateRow['item_name']== "Other")
                                            <x-input wire:key="other_rate" placeholder="{{ $editEstimateRow['rate'] }}"  wire:model.defer="rate" wire:keyup="calculateValue"/>
                                            @else
                                                {{ $editEstimateRow['rate'] }}
                                            @endif
                                        </td>
                                        <td>
                                            <x-input wire:key="total_amount" placeholder="{{ $editEstimateRow['total_amount'] }}"  wire:model.defer="total_amount" disabled/>
                                            {{-- {{ round($editEstimateRow['total_amount'], 10, 2) }} --}}
                                        </td>
                                    </tr>
                                    {{-- @dd($view) --}}
                                    {{-- {{ $editEstimateRow['row_id'] }} --}}
                                {{-- @endforeach --}}
                            @endif


                            @endisset
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- </div> --}}
            {{-- </div> --}}
            <x-slot name="footer">
                <div class="flex justify-between">
                    <div class="flex float-left">
                        <x-button class="btn btn-soft-danger px-3 py-2.5 rounded" flat label="Cancel" x-on:click="close" />
                    </div>
                    <div class="flex float-right">
                        <button wire:click.defer="updateEstimateRow" class="btn btn-soft-success px-3 py-2.5 rounded">
                            <x-lucide-edit class="w-4 h-4 text-gray-500" /> Update
                        </button>
                    </div>
                </div>
                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>
