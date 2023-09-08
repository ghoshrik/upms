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

                        {{-- <th class="whitespace-nowrap" style="text-align:center;">child ID
                        </th> --}}
                        <th class="whitespace-nowrap" >UNIT
                            </th>
                        <th class="whitespace-nowrap" >COST</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($this->viewCompositSOR)
                        @foreach ($viewCompositSOR as $lists)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td> {{ $lists['sor_itemno_child'] }}</td>
                                <td>
                                    {{ $lists['description'] }}
                                </td>
                                <td>
                                    {{ getunitName($lists['unit_id']) }}
                                </td>
                                <td>
                                    {{ $lists['rate'] }}
                                </td>
                                {{-- <td>
                                    <ul>
                                        @foreach ($this->viewCompositSOR['child'] as $data)
                                            <li>{{ $data['Item_details'] }}</li>
                                            <li>{{ $data['description'] }}</li>
                                        @endforeach
                                    </ul>
                                </td> --}}
                            </tr>
                        @endforeach
                    @endisset
                </tbody>
            </table>
        </x-card>
    </x-modal>
</div>
