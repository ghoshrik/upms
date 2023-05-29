<div>
    <x-modal max-width="5xl" blur wire:model.defer="viewModal">
        <x-card>
            {{-- <div class="modal-content"> --}}
                {{-- <div class="p-0 modal-body"> --}}
                    <div class="p-0 text-center">
                        <x-lucide-clipboard-list class="w-10 h-12 mx-auto text-success" />
                        <div class="mt-5 text-3xl">Details of Rate No : {{ $rate_id }}</div>
                        <div class="mt-2 text-slate-500"> </div>
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
                                                    {{ getSorItemNumber($view['sor_item_number']) }}
                                                    @elseif ($view['rate_no'])
                                                    {{ $view['rate_no'] }}
                                                @endif
                                            </td>
                                            <td class="text-wrap" style="width: 40rem">
                                                @if ($view['sor_item_number'])
                                                    {{ getSorItemNumberDesc($view['sor_item_number']) }}
                                                    @elseif ($view['rate_no'])
                                                    {{ getRateDescription($view['rate_no']) }}
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
                                                    {{ round($view['rate'],10,2) }}
                                                @endif
                                            </td>
                                            <td style="text-align:center;">{{ round($view['total_amount'],10,2) }}</td>
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
                </div>
                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>
