<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <x-modal max-width="5xl" blur wire:model.defer="viewVerifyModal">
        <x-card>
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
                    @foreach ($viewCompositSOR as $lists)
                    @endforeach
                </tbody>
            </table>
        </x-card>
    </x-modal>
</div>
