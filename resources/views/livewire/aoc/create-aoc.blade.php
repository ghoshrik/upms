<div>
    <x-form-section submit='store'>
        <x-slot name='form'>
            <div class="row">
                <div class="col-md-3 col-lg-3 col-sm-3">
                    {{-- <x-input label="{{ trans('cruds.aoc.fields.project_id') }}" wire:model.defer="projId" placeholder="{{ trans('cruds.aoc.fields.project_id') }}"/> --}}
                    <x-select label="Tender ID"
                    placeholder="Select Tender ID"
                    wire:model.defer="projId">
                        @foreach ($fetchData['project_number'] as $projects)
                            <x-select.option label="{{ $projects['estimate_id'] }}" value="{{ $projects['id'] }}" />
                        @endforeach
                    </x-select>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <x-input label="{{ trans('cruds.aoc.fields.title') }}" wire:model.defer="title" placeholder="{{ trans('cruds.aoc.fields.title') }}"/>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    {{-- <x-input label="{{ trans('cruds.aoc.fields.ref_no') }}" wire:model.defer="refcNo" placeholder="{{ trans('cruds.aoc.fields.ref_no') }}"/> --}}
                    <x-select label="{{ trans('cruds.aoc.fields.project_id') }}"
                    placeholder="Select {{ trans('cruds.funds.fields.project_id') }}"
                    wire:model.defer="refcNo">
                        @foreach ($fetchData['project_number'] as $projects)
                            <x-select.option label="{{ $projects['estimate_id'] }}" value="{{ $projects['id'] }}" />
                        @endforeach
                    </x-select>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <x-select
                        label="Select {{ trans('cruds.aoc.fields.category') }}"
                        placeholder="Select {{ trans('cruds.aoc.fields.category') }}"
                        :options="['Services', 'Goods', 'Works']"
                        wire:model.defer="category"
                    />
                </div>
            </div>
            <div class="row">
                <div class="col-12 mt-2">
                    <button type="submit" class="btn btn-success rounded-pill float-right">Save</button>
                </div>
            </div>
        </x-slot>
    </x-form-section>
</div>
