<div>

    <x-form-section submit='store'>
        <x-slot name='form'>
            <div class="row">
                <div class="col-md-3 col-lg-3 col-sm-3">
                    {{-- <x-input label="{{ trans('cruds.aoc.fields.ref_no') }}" wire:model.defer="refcNo" placeholder="{{ trans('cruds.aoc.fields.ref_no') }}"/> --}}
                    <x-select label="{{ trans('cruds.tenders.fields.project_id') }}"
                        placeholder="Select {{ trans('cruds.tenders.fields.project_id') }}"
                        wire:model.defer="InputStoreData.projID">
                        @foreach ($fetchData['project_number'] as $projects)
                            <x-select.option
                                label="{{ $projects['estimate_id'] . ' ' . 'Amount-' . $projects['total_project_cost'] }}"
                                value="{{ $projects['estimate_id'] }}" />
                        @endforeach
                    </x-select>
                </div>
                {{-- <div class="col-md-3 col-lg-3 col-sm-3">

                </div> --}}
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <x-input label="{{ trans('cruds.tenders.fields.tender_id') }}"
                        wire:model.defer="InputStoreData.tenderNo"
                        placeholder="{{ trans('cruds.tenders.fields.tender_id') }}" />
                    {{-- <x-select label="Tender ID"
                    placeholder="Select Tender ID"
                    wire:model.defer="projId">
                        @foreach ($fetchData['project_number'] as $projects)
                            <x-select.option label="{{ $projects['estimate_id'] }}" value="{{ $projects['id'] }}" />
                        @endforeach
                    </x-select> --}}
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <x-input label="{{ trans('cruds.tenders.fields.title') }}"
                        wire:model.defer="InputStoreData.tenderTitle"
                        placeholder="{{ trans('cruds.tenders.fields.title') }}" />
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <x-input label="{{ trans('cruds.tenders.fields.tender_amount') }}"
                        wire:model.defer="InputStoreData.tenderAmount"
                        placeholder="{{ trans('cruds.tenders.fields.tender_amount') }}" />
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3 mt-2">
                    <x-datetime-picker without-time label="{{ trans('cruds.tenders.fields.date_of_pub') }}"
                        placeholder="{{ trans('cruds.tenders.fields.date_of_pub') }}"
                        wire:model.defer="InputStoreData.publishDate" />
                </div>

                <div class="col-md-3 col-lg-3 col-sm-3 mt-2">
                    <x-datetime-picker without-time label="{{ trans('cruds.tenders.fields.date_of_close') }}"
                        placeholder="{{ trans('cruds.tenders.fields.date_of_close') }}"
                        wire:model.defer="InputStoreData.closeDate" />
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3 mt-2">
                    <x-input label="{{ trans('cruds.tenders.fields.num_bider') }}"
                        wire:model.defer="InputStoreData.BiderNo"
                        placeholder="{{ trans('cruds.tenders.fields.num_bider') }}" />
                </div>

                <div class="col-md-3 col-lg-3 col-sm-3 mt-2">
                    <x-select label="Select {{ trans('cruds.tenders.fields.category') }}"
                        placeholder="Select {{ trans('cruds.tenders.fields.category') }}" :options="['Services', 'Goods', 'Works']"
                        wire:model.defer="InputStoreData.tenderCategory" />
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
