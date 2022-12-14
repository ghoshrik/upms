<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div wire:loading.delay.longest.class="loading" class="card-body">
                    @foreach ($editRow as $data)
                        <div class="row mutipal-add-row">
                            <div class="col-md-12 col-sm-6 col-lg-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <x-select wire:key="deptCategory"
                                                label="{{ trans('cruds.sor.fields.dept_category') }}"
                                                placeholder="Select {{ trans('cruds.sor.fields.dept_category') }}"
                                                wire:model.defer="editRow.dept_category_id">
                                                @isset($fetchDropDownData['departmentCategory'])
                                                    @foreach ($fetchDropDownData['departmentCategory'] as $category)
                                                        <x-select.option label="{{ $category['dept_category_name'] }}"
                                                            value="{{ $category['id'] }}" />
                                                    @endforeach
                                                @endisset
                                            </x-select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <x-input wire:key='item_details' label="{{ trans('cruds.sor.fields.item_number') }}"
                                                placeholder="{{ trans('cruds.sor.fields.item_number') }}"
                                                wire:model.defer="editRow.item_details" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <x-input wire:key='unit' label="{{ trans('cruds.sor.fields.unit') }}"
                                                placeholder="{{ trans('cruds.sor.fields.unit') }}"
                                                wire:model.defer="editRow.unit" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <x-input wire:key='cost' label="{{ trans('cruds.sor.fields.cost') }}"
                                                placeholder="{{ trans('cruds.sor.fields.cost') }}"
                                                wire:model.defer="editRow.cost" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <x-select wire:key="version"
                                                label="{{ trans('cruds.sor.fields.version') }}"
                                                placeholder="Select {{ trans('cruds.sor.fields.version') }}"
                                                wire:model.defer="editRow.version"  :options="[
                                                    ['name' => '2015-16',  'id' => '2015-16'],
                                                    ['name' => '2016-17', 'id' => '2016-17'],
                                                    ['name' => '2017-18',   'id' => '2017-18'],
                                                    ['name' => '2018-19',    'id' => '2018-19'],
                                                ]"
                                                option-label="name"
                                                option-value="id"/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <x-datetime-picker without-time wire:key="effect_from"
                                                label="{{ trans('cruds.sor.fields.effect_from') }}"
                                                placeholder="{{ trans('cruds.sor.fields.effect_from') }}"
                                                wire:model.defer="editRow.effect_from" min="{{ now() }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <x-textarea rows="2" wire:key="description" wire:model="test"
                                                label="{{ trans('cruds.sor.fields.description') }}"
                                                placeholder="{{ trans('cruds.sor.fields.description') }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                            {{-- {{ $data['Item_details'] }} --}}
                    @endforeach
                    @php
                            print_r('<pre>');
                            print_r($sorEditData);
                            print_r('</pre>');
                            print_r('<pre>');
                            print_r($editRow);
                            print_r('</pre>');
                        @endphp
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12"><button type="submit" wire:click='store'
                                    class="btn btn-success rounded-pill float-right">Save</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
