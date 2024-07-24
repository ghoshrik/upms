<div>
    <x-modal max-width="5xl" blur wire:model.defer="openApproveModal">
        <x-card>
            {{-- <div class="modal-content"> --}}
            {{-- <div class="p-0 modal-body"> --}}
            <div class="p-0 text-center">
                <x-lucide-clipboard-list class="w-10 h-12 mx-auto text-success" />
                <div class="mt-5 text-3xl">Details of Estimate No : {{ $estimate_id }}</div>
                <div class="mt-2 text-slate-500"> </div>
                <div>
                    <table class="table mt-2 table-report">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap">#</th>
                                <th class="whitespace-nowrap">Estimate No</th>
                                <th class="whitespace-nowrap" style="width:40%;text-align:center;">
                                    DESCRIPTION</th>
                                <th class="whitespace-nowrap" style="text-align:center;">COST</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($viewEstimates as $view) --}}
                            @if ($viewEstimates != '')
                                <tr>
                                    <td>1.</td>
                                    <td class="text-wrap">
                                        {{ $viewEstimates['estimate_id'] }}
                                    </td>
                                    <td class="text-wrap">
                                        {{ $viewEstimates['sorMasterDesc'] }}
                                    </td>
                                    <td style="text-align:end;">
                                        {{-- @if ($view['qty'] == 0)
                                        @else
                                            {{ $view['qty'] }}
                                        @endif --}}
                                        {{ number_format($viewEstimates['total_amount'], 2) }}
                                    </td>
                                    {{-- <td style="text-align:center;">
                                        @if ($view['rate'] == 0)
                                        @else
                                            {{ round($view['rate'], 10, 2) }}
                                        @endif
                                    </td>
                                    <td style="text-align:center;">{{ round($view['total_amount'], 10, 2) }}</td> --}}
                                </tr>
                                {{-- @endforeach --}}
                            @endif
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
                    <div class="flex float-right">
                        <button wire:click="approveEstimate({{ $estimate_id }})" class="btn btn-soft-success">
                            <x-lucide-verified class="w-4 h-4 text-gray-500" /> Approve
                        </button>
                    </div>
                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>
