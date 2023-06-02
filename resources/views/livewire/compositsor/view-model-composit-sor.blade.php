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

                        <th class="whitespace-nowrap" style="text-align:center;">child ID
                        </th>
                        <th class="whitespace-nowrap" style="text-align:right;">UNIT
                            PRICE</th>
                        <th class="whitespace-nowrap" style="text-align:center;">COST</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($this->viewCompositSOR['parent'])
                        @foreach ($viewCompositSOR['parent'] as $lists)
                            <tr>
                                <td> {{ $lists->Item_details }}</td>
                                <td>
                                    {{ $lists->description }}
                                </td>
                                <td>
                                    <ul>
                                        @foreach ($this->viewCompositSOR['child'] as $data)
                                            <li>{{ $data['Item_details'] }}</li>
                                            <li>{{ $data['description'] }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    @endisset
                </tbody>
            </table>
        </x-card>
    </x-modal>
</div>
