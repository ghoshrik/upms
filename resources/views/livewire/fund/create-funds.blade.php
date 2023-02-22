<div>
    <x-form-section submit='store'>
        <x-slot name='form'>
            <div class="row">
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <x-select label="{{ trans('cruds.funds.fields.project_id') }}"
                    placeholder="Select {{ trans('cruds.funds.fields.project_id') }}"
                    wire:model.defer="storeInputData.projectId">
                        @foreach ($fetchData['project_number'] as $projects)
                            <x-select.option label="{{ $projects['estimate_id'] }}" value="{{ $projects['id'] }}" />
                        @endforeach
                    </x-select>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <x-input label="{{trans('cruds.funds.fields.go_id')}}" wire:model.defer="storeInputData.goId" placeholder="{{trans('cruds.funds.fields.go_id')}}" />
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <x-select label="{{ trans('cruds.funds.fields.vendor_id') }}"
                    placeholder="Select {{ trans('cruds.funds.fields.vendor_id') }}"
                    wire:model.defer="storeInputData.vendorId">
                        @foreach ($fetchData['vendors'] as $vendor)
                            <x-select.option label="{{ $vendor['comp_name'] }}" value="{{ $vendor['id'] }}" />
                        @endforeach
                    </x-select>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <x-datetime-picker without-time
                        label="{{ trans('cruds.funds.fields.approved_date') }}"
                        placeholder="{{ trans('cruds.funds.fields.approved_date') }}"

                        wire:model.defer="storeInputData.approvedDate" />
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3 mt-2">
                    <x-input wire:model.defer="storeInputData.amount"
                    label="{{ trans('cruds.funds.fields.amount') }}" placeholder="{{ trans('cruds.funds.fields.amount') }}" />
                </div>
                {{-- <div class="col-md-3 col-lg-3 col-sm-3 mt-2">
                   <div class="form-group">
                    <label for="">{{ trans('cruds.funds.fields.support_data') }}</label>
                    <input type="file" wire:model="storeInputData.uploadData" class="form-control"/>
                   </div>
                </div> --}}

            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-success rounded-pill float-right">Save</button>
                </div>
            </div>
        </x-slot>
    </x-form-section>
</div>
