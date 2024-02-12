<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div wire:loading.delay.longest.class="loading" class="card-body">
                    {{-- <div class="card-body"> --}}
                    <div class="row">
                        <div class="row">
                            <div class="col col-md-6 col-lg-8 col-sm-12 col-xs-12 mb-2">
                                <x-textarea wire:model.defer="sorMasterDesc" rows="2"
                                    label="{{ trans('cruds.estimate.fields.description') }}"
                                    placeholder="Your project {{ trans('cruds.estimate.fields.description') }}" />
                            </div>
                            <div class="col col-md-3 col-lg-1 col-sm-12 col-xs-12 mb-2">
                                @if ($part_no != '')
                                    <x-input label="Part No" placeholder="Part No" wire:model.defer="part_no"
                                        wire:key='part_no' readonly />
                                @else
                                    <x-input label="Part No" placeholder="Part No" wire:model.defer="part_no"
                                        wire:key='part_no'
                                        oninput="this.value = this.value.replace(/[^a-zA-Z]/g, '').substring(0, 1);" />
                                @endif
                            </div>
                            <div class="col col-md-3 col-lg-3 col-sm-12 col-xs-12 mb-2">
                                <div class="form-group">
                                    <x-select wire:key="categoryType"
                                        label="{{ trans('cruds.estimate.fields.category') }}"
                                        placeholder="Select {{ trans('cruds.estimate.fields.category') }}"
                                        wire:model.defer="selectedCategoryId"
                                        x-on:select="$wire.changeCategory($event.target)" :options="[
                                            ['name' => 'SOR', 'id' => 1],
                                            ['name' => 'Other', 'id' => 2],
                                            ['name' => 'Estimate', 'id' => 3],
                                            ['name' => 'Rate', 'id' => 4],
                                        ]"
                                        option-label="name" option-value="id" />
                                </div>
                            </div>
                        </div>
                        @if (!empty($estimateData))
                            @if ($estimateData['item_name'] == 'SOR')
                                <div class="row" style="transition: all 2s ease-out">
                                    <div class="col">
                                        <div class="form-group">
                                            <x-select wire:key="dept" label="{{ trans('cruds.estimate.fields.dept') }}"
                                                placeholder="Select {{ trans('cruds.estimate.fields.dept') }}"
                                                wire:model.defer="estimateData.dept_id"
                                                x-on:select="$wire.getDeptCategory()">
                                                @foreach ($fatchDropdownData['departments'] as $department)
                                                    <x-select.option label="{{ $department['department_name'] }}"
                                                        value="{{ $department['id'] }}" />
                                                @endforeach
                                            </x-select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-select wire:key="category"
                                                label="{{ trans('cruds.estimate.fields.category') }}"
                                                placeholder="Select {{ trans('cruds.estimate.fields.category') }}"
                                                wire:model.defer="estimateData.dept_category_id"
                                                x-on:select="$wire.getVolumn()">
                                                @isset($fatchDropdownData['departmentsCategory'])
                                                    @foreach ($fatchDropdownData['departmentsCategory'] as $deptCategory)
                                                        <x-select.option label="{{ $deptCategory['dept_category_name'] }}"
                                                            value="{{ $deptCategory['id'] }}" />
                                                    @endforeach
                                                @endisset
                                            </x-select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-select wire:key="volume" label="Volume" placeholder="Select Volume"
                                                wire:model.defer="estimateData.volume" x-on:select="$wire.getTableNo()">
                                                @isset($fatchDropdownData['volumes'])
                                                    @foreach ($fatchDropdownData['volumes'] as $volume)
                                                        <x-select.option label="{{ getVolumeName($volume['volume_no']) }}"
                                                            value="{{ $volume['volume_no'] }}" />
                                                    @endforeach
                                                @endisset
                                            </x-select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-select wire:key="table_no" label="Table No" placeholder="Select Table No"
                                                wire:model.defer="estimateData.table_no"
                                                x-on:select="$wire.getPageNo()">
                                                @isset($fatchDropdownData['table_no'])
                                                    @foreach ($fatchDropdownData['table_no'] as $table)
                                                        <x-select.option label="{{ $table['table_no'] }}"
                                                            value="{{ $table['table_no'] }}" />
                                                    @endforeach
                                                @endisset

                                            </x-select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-select wire:key="page_no" label="Page No" placeholder="Select Page No"
                                                wire:model.defer="estimateData.id" x-on:select="$wire.getDynamicSor()">
                                                @foreach ($fatchDropdownData['page_no'] as $page)
                                                    <x-select.option
                                                        label="{{ $page['page_no'] . ($page['corrigenda_name'] != null ? ' - ' . $page['corrigenda_name'] : '') }}"
                                                        value="{{ $page['id'] }}" />
                                                @endforeach
                                            </x-select>
                                        </div>
                                    </div>
                                    {{-- <div class="col">
                                        <div class="form-group">
                                            <x-select wire:key="version"
                                                label="{{ trans('cruds.estimate.fields.version') }}"
                                                placeholder="Select {{ trans('cruds.estimate.fields.version') }}"
                                                wire:model.defer="estimateData.version"
                                                x-on:select="$wire.getVersion()">
                                                @isset($fatchDropdownData['versions'])
                                                    @foreach ($fatchDropdownData['versions'] as $version)
                                                        <x-select.option label="{{ $version['version'] }}"
                                                            value="{{ $version['version'] }}" />
                                                    @endforeach
                                                @endisset
                                            </x-select>
                                        </div>
                                        </div> --}}
                                    {{-- <div class="col"> --}}
                                    {{-- <div class="form-group search-sor"> --}}
                                    {{-- <x-select wire:key="sor"
                                                label="Select {{ trans('cruds.estimate.fields.sor') }}"
                                                placeholder="Select {{ trans('cruds.estimate.fields.sor') }}"
                                                wire:model.defer="selectedSORKey" x-on:select="$wire.getItemDetails()"
                                                dynamicSearch=true>
                                                @isset($this->fatchDropdownData['items_number'])
                                                    @foreach ($this->fatchDropdownData['items_number'] as $key => $item)
                                                        <x-select.option label="{{ $item['Item_details'] }}"
                                                            value="{{ $key }}" />
                                                    @endforeach
                                                @endisset
                                            </x-select> --}}
                                    {{-- <div class="dropdown">
                                                <x-input wire:key="sor"
                                                    label="{{ trans('cruds.estimate.fields.sor') }}"
                                                    placeholder="{{ trans('cruds.estimate.fields.sor') }}"
                                                    wire:model.defer="selectedSORKey" value="{{ $selectedSORKey }}"
                                                    wire:keydown.escape="resetValus" wire:keydown.tab="autoSearch"
                                                    class="dropbtn" />


                                                @isset($this->fatchDropdownData['items_number'])
                                                    @if (count($this->fatchDropdownData['items_number']) > 0)
                                                        <div class="dropdown-content"
                                                            style="display:{{ $searchDtaCount ? $searchStyle : $searchStyle }}">
                                                            @foreach ($this->fatchDropdownData['items_number'] as $list)
                                                                <a href="javascript:void(0);"
                                                                    wire:click="getItemDetails({{ $list['id'] }})"><b>{{ $list['Item_details'] }}</b>
                                                                    <sub>{{ $list['description'] }}</sub></a>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                @endisset
                                            </div> --}}
                                    {{-- </div> --}}
                                    {{-- </div> --}}
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <x-input wire:key="sor_desc"
                                                label="{{ trans('cruds.estimate.fields.description') }}"
                                                placeholder="{{ trans('cruds.estimate.fields.description') }}" disabled
                                                wire:model.defer="estimateData.description" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            @if ($estimateData['unit_id'] == 0 || $estimateData['unit_id'] == '')
                                                <x-select wire:key="unit_" label="Unit" placeholder="Select Unit"
                                                    wire:model.defer="estimateData.unit_id">
                                                    @foreach ($fatchDropdownData['units'] as $unit)
                                                        <x-select.option label="{{ $unit['unit_name'] }}"
                                                            value="{{ $unit['id'] }}" />
                                                    @endforeach
                                                </x-select>
                                            @else
                                                <x-input wire:key='unit_' label="Unit Name" placeholder="Unit Name"
                                                    wire:model.defer="estimateData.unit_id" readonly />
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-input wire:key="sor_qty"
                                                label="{{ trans('cruds.estimate.fields.quantity') }}"
                                                placeholder="{{ trans('cruds.estimate.fields.quantity') }}"
                                                wire:model.defer="estimateData.qty" wire:blur="calculateValue" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-input wire:key="sor_rate"
                                                label="{{ trans('cruds.estimate.fields.per_unit_cost') }}"
                                                placeholder="{{ trans('cruds.estimate.fields.per_unit_cost') }}"
                                                readonly wire:model.defer="estimateData.rate" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-input wire:key="sor_cost"
                                                label="{{ trans('cruds.estimate.fields.cost') }}"
                                                placeholder="{{ trans('cruds.estimate.fields.cost') }}" disabled
                                                wire:model.defer="estimateData.total_amount" />
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($estimateData['item_name'] == 'Other')
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <x-input wire:key="other_name" wire:model.defer="estimateData.other_name"
                                                label="Item Name" placeholder="Item Name" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-select wire:key="unit_" label="Unit" placeholder="Select Unit"
                                                wire:model.defer="estimateData.unit_id">
                                                @isset($fatchDropdownData['units'])
                                                    @foreach ($fatchDropdownData['units'] as $value)
                                                        <x-select.option label="{{ $value['unit_name'] }}"
                                                            value="{{ $value['unit_name'] }}" />
                                                    @endforeach
                                                @endisset
                                            </x-select>
                                            {{-- <x-input wire:key='unit_' label="Unit Name" placeholder="Unit Name"
                                                    wire:model.defer="estimateData.unit_id" /> --}}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-input wire:key="other_qty" wire:model.defer="estimateData.qty"
                                                wire:blur="calculateValue"
                                                label="{{ trans('cruds.estimate.fields.quantity') }}"
                                                placeholder="{{ trans('cruds.estimate.fields.quantity') }}" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-input wire:key="other_rate" wire:model.defer="estimateData.rate"
                                                wire:blur="calculateValue"
                                                label="{{ trans('cruds.estimate.fields.per_unit_cost') }}"
                                                placeholder="{{ trans('cruds.estimate.fields.per_unit_cost') }}" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-input wire:key="other_cost"
                                                wire:model.defer="estimateData.total_amount"
                                                label="{{ trans('cruds.estimate.fields.cost') }}" disabled
                                                placeholder="{{ trans('cruds.estimate.fields.cost') }}" />
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($estimateData['item_name'] == 'Estimate')
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <x-select wire:key="dept"
                                                label="{{ trans('cruds.estimate.fields.dept') }}"
                                                placeholder="Select {{ trans('cruds.estimate.fields.dept') }}"
                                                wire:model.defer="estimateData.dept_id"
                                                x-on:select="$wire.getDeptEstimates()">
                                                @isset($fatchDropdownData['departments'])
                                                    @foreach ($fatchDropdownData['departments'] as $department)
                                                        <x-select.option label="{{ $department['department_name'] }}"
                                                            value="{{ $department['id'] }}" />
                                                    @endforeach
                                                @endisset
                                            </x-select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-select wire:key="estimate_no" label="{{ __('Select Estimate') }}"
                                                placeholder="Select {{ __('Estimate') }}"
                                                wire:model.defer="estimateData.estimate_no"
                                                x-on:select="$wire.getEstimateDetails()">
                                                @isset($fatchDropdownData['estimatesList'])
                                                    @foreach ($fatchDropdownData['estimatesList'] as $estimate)
                                                        <x-select.option
                                                            label="{{ $estimate['estimate_id'] . ' - ' . $estimate['sorMasterDesc'] }}"
                                                            value="{{ $estimate['estimate_id'] }}" />
                                                    @endforeach
                                                @endisset
                                            </x-select>
                                        </div>
                                    </div>
                                    {{-- @isset($fatchDropdownData['estimateDetails']) --}}
                                    {{-- <div class="col">
                                        <div class="form-group">
                                            <x-textarea rows="2" wire:key="other_rate"
                                                wire:model.defer="estimateData.description"
                                                wire:blur="calculateValue"
                                                label="Estimate {{ trans('cruds.estimate.fields.description') }}"
                                                placeholder="Estimate {{ trans('cruds.estimate.fields.description') }}"
                                                disabled />
                                        </div>
                                        </div> --}}
                                    <div class="col">
                                        <div class="form-group">
                                            <x-select wire:key="unit_" label="Unit" placeholder="Select Unit"
                                                wire:model.defer="estimateData.unit_id">
                                                @isset($fatchDropdownData['units'])
                                                    @foreach ($fatchDropdownData['units'] as $value)
                                                        <x-select.option label="{{ $value['unit_name'] }}"
                                                            value="{{ $value['unit_name'] }}" />
                                                    @endforeach
                                                @endisset
                                            </x-select>
                                            {{-- <x-input wire:key='unit_' label="Unit Name" placeholder="Unit Name"
                                                    wire:model.defer="estimateData.unit_id" /> --}}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-input wire:key="other_qty" wire:model.defer="estimateData.qty"
                                                wire:blur="calculateValue"
                                                label="{{ trans('cruds.estimate.fields.quantity') }}"
                                                placeholder="{{ trans('cruds.estimate.fields.quantity') }}" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-input wire:key="sor_rate"
                                                label="{{ trans('cruds.estimate.fields.per_unit_cost') }}"
                                                placeholder="{{ trans('cruds.estimate.fields.per_unit_cost') }}"
                                                readonly wire:model.defer="estimateData.rate" />
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-input wire:key="total_amount"
                                                wire:model.defer="estimateData.total_amount"
                                                label="{{ trans('cruds.estimate.fields.estimate_total') }}" disabled
                                                placeholder="{{ trans('cruds.estimate.fields.estimate_total') }}" />
                                        </div>
                                    </div>
                                    {{-- @endisset --}}

                                </div>
                            @endif
                            @if ($estimateData['item_name'] == 'Rate')
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <x-select wire:key="dept"
                                                label="{{ trans('cruds.estimate.fields.dept') }}"
                                                placeholder="Select {{ trans('cruds.estimate.fields.dept') }}"
                                                wire:model.defer="estimateData.dept_id"
                                                x-on:select="$wire.getDeptRates()">
                                                @isset($fatchDropdownData['departments'])
                                                    @foreach ($fatchDropdownData['departments'] as $department)
                                                        <x-select.option label="{{ $department['department_name'] }}"
                                                            value="{{ $department['id'] }}" />
                                                    @endforeach
                                                @endisset
                                            </x-select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <x-select wire:key="rate_no" label="{{ __('Select Rate') }}"
                                                placeholder="Select {{ __('Rate') }}"
                                                wire:model.defer="estimateData.rate_no"
                                                x-on:select="$wire.getRateDetailsTypes()">
                                                @isset($fatchDropdownData['ratesList'])
                                                    @foreach ($fatchDropdownData['ratesList'] as $rate)
                                                        <x-select.option
                                                            label="{{ $rate['rate_id'] . ' - ' . $rate['description'] }}"
                                                            value="{{ $rate['rate_id'] }}" />
                                                    @endforeach
                                                @endisset
                                            </x-select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="from-group">
                                            <x-select wire:key='rate_type' label="{{ __('Select Rate Type') }}"
                                                placeholder="Select{{ __('Type') }}"
                                                wire:model.defer="estimateData.rate_type"
                                                x-on:select="$wire.getRateDetails()">
                                                @isset($fatchDropdownData['rateDetailsTypes'])
                                                    @foreach ($fatchDropdownData['rateDetailsTypes'] as $rateType)
                                                        <x-select.option label="{{ $rateType['operation'] }}"
                                                            value="{{ $rateType['operation'] }}" />
                                                    @endforeach
                                                @endisset
                                            </x-select>
                                        </div>
                                    </div>
                                    {{-- @isset($fatchDropdownData['estimateDetails']) --}}
                                    {{-- <div class="col">
                                        <div class="form-group">
                                            <x-textarea rows="2" wire:key="other_rate"
                                                wire:model.defer="estimateData.description"
                                                wire:blur="calculateValue"
                                                label="Estimate {{ trans('cruds.estimate.fields.description') }}"
                                                placeholder="Estimate {{ trans('cruds.estimate.fields.description') }}"
                                                disabled />
                                        </div>
                                        </div> --}}
                                    <div class="form-group">
                                        <x-select wire:key="qnty_type"
                                            label="{{ trans('cruds.estimate.fields.quantity') }}"
                                            placeholder="Select {{ trans('cruds.estimate.fields.quantity') }}"
                                            wire:model.defer="quntity_type_id"
                                            x-on:select="$wire.changeQuntity($event.target)" :options="[
                                                ['name' => 'Qutity Evaluation', 'id' => 1],
                                                ['name' => 'Menual', 'id' => 2],
                                            ]"
                                            option-label="name" option-value="id" />
                                    </div>
                                    @if ($quntity_type_id == 2)
                                        <div class="col">
                                            <div class="form-group">
                                                <x-input wire:key="qty_menual" wire:model.defer="estimateData.qty"
                                                    wire:blur="calculateValue"
                                                    label="{{ trans('cruds.estimate.fields.quantity') }}"
                                                    placeholder="{{ trans('cruds.estimate.fields.quantity') }}" />
                                            </div>
                                        </div>
                                    @else
                                        <div class="col">
                                            <div class="form-group">
                                                <x-select wire:key="qty_a_value" label="{{ __('Select Quantity') }}"
                                                    placeholder="Select {{ __('Quantity') }}"
                                                    wire:model.defer="estimateData.qty"
                                                    x-on:select="$wire.calculateValue()">
                                                    @isset($fatchDropdownData['qultiyEvaluation'])
                                                        @foreach ($fatchDropdownData['qultiyEvaluation'] as $estimate)
                                                            {{-- <x-select.option label="{{ $estimate['estimate_id'].' - '.$estimate['sorMasterDesc'] }}" --}}
                                                            <x-select.option label="{{ $estimate['value'] }}"
                                                                value="{{ $estimate['value'] }}" />
                                                        @endforeach
                                                    @endisset
                                                </x-select>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <x-select wire:key="unit_" label="Unit" placeholder="Select Unit"
                                            wire:model.defer="estimateData.unit_id">
                                            @isset($fatchDropdownData['units'])
                                                @foreach ($fatchDropdownData['units'] as $value)
                                                    <x-select.option label="{{ $value['unit_name'] }}"
                                                        value="{{ $value['unit_name'] }}" />
                                                @endforeach
                                            @endisset
                                        </x-select>
                                        {{-- <x-input wire:key='unit_' label="Unit Name" placeholder="Unit Name"
                                                wire:model.defer="estimateData.unit_id" /> --}}
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <x-input wire:key="sor_rate"
                                            label="{{ trans('cruds.estimate.fields.per_unit_cost') }}"
                                            placeholder="{{ trans('cruds.estimate.fields.per_unit_cost') }}" readonly
                                            wire:model.defer="estimateData.rate" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <x-input wire:key="total_amount" wire:model.defer="estimateData.total_amount"
                                            label="Rate Total" disabled placeholder="Rate Total" />
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group float-right">
                                <button type="button" wire:click='addEstimate'
                                    class="{{ trans('global.add_btn_color') }}">
                                    <x-lucide-list-plus class="w-4 h-4 text-gray-500" />
                                    {{ trans('global.add_btn') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>
    @if ($addedEstimate != null || Session::has('addedProjectEstimateData') || $editEstimate_id != '')
        <div x-transition.duration.500ms>
            <livewire:estimate-project.added-estimate-project-list :addedEstimateData="$addedEstimate" :sorMasterDesc="$sorMasterDesc"
                :wire:key="$addedEstimateUpdateTrack" :part_no="$part_no" />
        </div>
    @endif
    @if ($viewModal)
        <div>
            <div class="modal" id="{{ $modalName }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                @isset($getSor->table_no)
                                    {{ $getSor->table_no . ' - ' . $getSor->title }}
                                @endisset
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="tabulator_table"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button"id="closeBtn" class="btn btn-secondary"
                                data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php
            $tableNo = isset($estimateData['table_no']) ? $estimateData['table_no'] : $selectSor['table_no'];
            $pageNo = isset($estimateData['page_no']) ? $estimateData['page_no'] : $selectSor['page_no'];
        @endphp
        <script>
            document.getElementById("closeBtn").addEventListener("click", function() {
                closeModal();
            });

            function closeModal() {
                $('#' + @json($modalName)).modal('hide');
                window.Livewire.emit('closeModal');
            }
            $(document).ready(function() {
                var clickableCellValues = [];
                $("#" + @json($modalName)).modal({
                    backdrop: "static",
                    keyboard: false
                });
                var headerData = @json(json_decode($getSor['header_data']));
                var rowData = @json(json_decode($getSor['row_data']));
                headerData.forEach(function(column) {
                    var fun;
                    delete column.editor;
                    if (column.field === 'desc_of_item') {
                        column.frozen = true;
                    }
                    if (column.field === 'item_no') {
                        column.frozen = true;
                    }
                    if (column.field === 'unit') {
                        column.frozen = true;
                    }
                    if (column.isClick) {
                        column.isClick = eval('(' + column.isClick + ')');
                        fun = column.isClick;
                    }
                    if (column.cellClick) {
                        column.cellClick = eval('(' + column.isClick + ')');
                        fun = column.cellClick;
                    }
                    if (typeof fun === "function") {
                        column.cellClick = function(e, cell) {
                            // Overwritten cellClick function
                            var getData = cell.getRow().getData();
                            var colId = cell.getField();
                            var allColumn = cell.getTable().columnManager.getColumns();
                            var colIdx = -1;
                            var colName;
                            for (var i = 0; i < allColumn.length; i++) {
                                if (allColumn[i]['columns'] && allColumn[i]['columns'].length > 0) {
                                    var allGroupCol = allColumn[i]['columns'];
                                    for (var j = 0; j < allGroupCol.length; j++) {
                                        if (allGroupCol[j].getField() === colId) {
                                            colIdx = i + j;
                                            colName = allGroupCol[j].getField();
                                            colName = colName.replace(/_/g, ' ');
                                            break;
                                        }
                                    }
                                } else {
                                    if (allColumn[i].getField() === colId) {
                                        colIdx = i;
                                        colName = column.title;
                                        break;
                                    }
                                }
                            }
                            var getRowData = [{
                                id: getData['id'],
                                desc: (getData['desc_of_item']) ? getData['desc_of_item'] : '',
                                unit: (getData['unit']) ? getData['unit'] : '',
                                rowValue: cell.getValue(),
                                itemNo: cell.getRow().getIndex(),
                                colPosition: colIdx
                            }];
                            var cnf = confirm("Are you sure to select " + colName +
                                " Value = " + cell.getValue() + " ?");
                            if (cnf) {
                                window.Livewire.emit('getRowValue', getRowData);
                                // window.Livewire.emit('getRowValue', getData);
                                // window.Livewire.emit('getRowValue', clickableCellValues);
                                // var modalToggle = document.getElementById(@json($modalName));
                                $('#' + @json($modalName)).modal('hide');
                                // Add your custom code or logic here
                            }
                        };
                    }
                    if (column.columns) {
                        column.columns.forEach(function(subColumn) {
                            var subFun;
                            delete subColumn.editor;
                            if (subColumn.isClick) {
                                subFun = subColumn.isClick = eval('(' + subColumn.isClick + ')');
                            }
                            if (subColumn.cellClick) {
                                subFun = subColumn.cellClick = eval('(' + subColumn.cellClick + ')');
                            }
                            if (typeof subFun === "function") {
                                subColumn.cellClick = function(e, cell) {
                                    var subrowIndex = cell.getRow().getIndex();
                                    var getData = cell.getRow().getData();
                                    var colId = cell.getField();
                                    var allColumn = cell.getTable().columnManager.getColumns();
                                    var colIdx = -1;
                                    var colName;
                                    var colTitle = column.title;
                                    for (var i = 0; i < allColumn.length; i++) {
                                        if (allColumn[i]['columns'] && allColumn[i]['columns']
                                            .length > 0) {
                                            var allGroupCol = allColumn[i]['columns'];
                                            for (var j = 0; j < allGroupCol.length; j++) {
                                                if (allGroupCol[j].getField() === colId) {
                                                    colIdx = i + j;
                                                    colName = allGroupCol[j].getField();
                                                    colName = colName.replace(/_/g, ' ');
                                                    break;
                                                }
                                            }
                                        } else {
                                            if (allColumn[i].getField() === colId) {
                                                colIdx = i;
                                                colName = column.title;
                                                break;
                                            }
                                        }
                                    }
                                    var getRowData = [{
                                        id: getData['id'],
                                        desc: (getData['desc_of_item']) ? getData[
                                            'desc_of_item'] : '',
                                        unit: (getData['unit']) ? getData['unit'] : (
                                            getData['unit_' + colTitle]) ? getData[
                                            'unit_' + colTitle] : '',
                                        rowValue: cell.getValue(),
                                        itemNo: subrowIndex,
                                        colPosition: colIdx
                                    }];
                                    var cnf = confirm("Are you sure to select " + colName +
                                        " Value = " + cell.getValue() + " ?");
                                    if (cnf) {
                                        window.Livewire.emit('getRowValue', getRowData);
                                        // window.Livewire.emit('getRowValue', getData);
                                        $('#' + @json($modalName)).modal('hide');
                                    }
                                };
                            }
                        });
                    }
                });

                var delay = 1000; // Delay time in milliseconds

                var delayPromise = new Promise(function(resolve) {
                    setTimeout(function() {
                        resolve();
                    }, delay);
                });

                delayPromise.then(function() {
                    var table = new Tabulator("#tabulator_table", {
                        height: "711px",
                        columnVertAlign: "bottom",
                        layout: "fitDataFill",
                        columns: headerData,
                        columnHeaderVertAlign: "center",
                        data: rowData,
                        variableHeight: true,
                        variableWidth: true,
                        dataTree: true, // Enable the dataTree module
                        dataTreeStartExpanded: true, // Optional: Expand all rows by default
                        dataTreeChildField: "_subrow", // Specify the field name for subrows
                        dataTreeChildIndent: 10, // Optional: Adjust the indentation level of subrows
                    });

                    // Title of the modal
                    var tableNo = @json($tableNo);
                    var pageNo = @json($pageNo);
                    var modalId = "exampleModal_" + tableNo + "_" + pageNo;

                    $("#" + @json($modalName)).modal("show");
                });
            });
        </script>
    @endif
</div>
{{-- <script>
    // Save the original fetch function
    const originalFetch = window.fetch;

    window.fetch = function(url, options) {
        // if (options.method && options.method.toUpperCase() === 'POST') {
        try {
            const temp = JSON.parse(options.body);

            if (typeof temp.serverMemo === 'string') {
                return originalFetch(url, options); // Return the original fetch for this case
            } else {
                temp.serverMemo = btoa(unescape(encodeURIComponent(JSON.stringify(temp.serverMemo))));
            }

            if (typeof temp.updates === 'string') {
                return originalFetch(url, options); // Return the original fetch for this case
            } else {
                temp.updates = btoa(unescape(encodeURIComponent(JSON.stringify(temp.updates))));
            }

            options.body = JSON.stringify(temp);
        } catch (error) {
            // console.error('Error parsing JSON:', error);
            return originalFetch(url, options); // Return the original fetch if there's an error parsing JSON
        }
        // }

        // Call the original fetch function
        return originalFetch(url, options)
            .then(response => {
                return response;
            })
            .catch(error => {
                // Handle errors
                console.error('Error:', error);
            });
    };
</script> --}}
