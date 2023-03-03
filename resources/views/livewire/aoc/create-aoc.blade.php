<div>
    <x-form-section submit='store'>
        <x-slot name='form'>
            <div class="row">
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <x-select label="{{ trans('cruds.aocs.fields.project_id') }}"
                    placeholder="Select {{ trans('cruds.aocs.fields.project_id') }}"
                    wire:model.defer="storeInputData.projectId" x-on:select="$wire.changeProjectID()">
                        @foreach ($fetchData['project_number'] as $projects)
                            <x-select.option label="{{ $projects['project_id'] }}" value="{{ $projects['project_id'] }}" />
                        @endforeach
                    </x-select>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3">
                    <x-input label="{{trans('cruds.aocs.fields.go_id')}}"  wire:model.defer="storeInputData.goId" placeholder="{{trans('cruds.aocs.fields.go_id')}}" />
                </div>
                <div class="col-md-6 col-lg-6 col-sm-3">
                    <x-select label="{{ trans('cruds.aocs.fields.vendor_id') }}" placeholder="Select {{ trans('cruds.aocs.fields.vendor_id') }}" wire:model.defer="storeInputData.vendorId" multiselect>
                            @foreach ($fetchData['vendors'] as $user)
                            <x-select.option label="{{ $user['comp_name'] }}" value="{{ $user['id'] }}" />
                            @endforeach
                    </x-select>
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3 mt-2">
                    <x-datetime-picker without-time
                        label="{{ trans('cruds.aocs.fields.approved_date') }}"
                        placeholder="{{ trans('cruds.aocs.fields.approved_date') }}"

                        wire:model.defer="storeInputData.approvedDate" />
                </div>
                <div class="col-md-3 col-lg-3 col-sm-3 mt-2">
                    <x-input wire:model.defer="storeInputData.amount"
                    label="{{ trans('cruds.aocs.fields.amount') }}" placeholder="{{ trans('cruds.aocs.fields.amount') }}" />
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
