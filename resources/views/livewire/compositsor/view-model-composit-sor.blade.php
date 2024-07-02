<div>
    <x-modal max-width="5xl" blur wire:model.defer="viewVerifyModal">
        <x-card>
            <h3>
                {{-- @isset($sor_itemno_parent_id, $sor_itemno_parent_index)
                    {{ getTableDesc($sor_itemno_parent_id, $sor_itemno_parent_index) }}
                @endisset --}}
            </h3>
            <table class="table mt-2 table-report">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">ITEM
                            NUMBER/PAGE NO</th>
                        <th class="whitespace-nowrap" style="width:40%;text-align:center;">
                            DESCRIPTION</th>

                        {{-- <th class="whitespace-nowrap" style="text-align:center;">child ID
                        </th> --}}
                        <th class="whitespace-nowrap">UNIT
                        </th>
                        <th class="whitespace-nowrap">QUANTITY</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($this->viewCompositSOR)
                        @foreach ($viewCompositSOR as $lists)
                            <tr>
                                <td class="text-wrap">
                                    @if ($lists['is_row'] == 0)
                                        {{ getSorPageNo($lists['sor_itemno_child_id']) }}
                                        {{-- @if (getSorCorrigenda($lists['sor_itemno_child_id'] != null)) --}}
                                        {{ getSorCorrigenda($lists['sor_itemno_child_id']) != '' ? '(' . getSorCorrigenda($lists['sor_itemno_child_id']) . ')' : '' }}
                                        {{-- @endif --}}
                                    @else
                                        {{ $lists['sor_itemno_child'] }}
                                    @endif
                                </td>
                                <td class="text-wrap">
                                    {{ $lists['description'] }}
                                </td>
                                <td class="text-wrap">
                                    {{ getunitName($lists['unit_id']) }}
                                </td>
                                <td class="text-wrap">
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
            <x-slot name="footer">
                <div class="flex justify-between">
                    <div class="flex float-left">
                        <x-button class="btn btn-soft-danger px-3 py-2.5 rounded" flat label="Cancel"
                            x-on:click="close" />
                    </div>
                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>
