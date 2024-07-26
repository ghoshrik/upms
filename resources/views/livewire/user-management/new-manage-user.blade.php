<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div class="card-body">
                    {{-- @dd(Auth::user()->getRoleNames()[0] === 'State Admin'); --}}
                    {{-- @if (Auth::user()->getRoleNames()[0] $isChecked) --}}
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1"
                                value="option1">
                            <label class="form-check-label" for="inlineRadio1"> Create User for Own Office</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2"
                                value="option2">
                            <label class="form-check-label" for="inlineRadio2">Create User for Other Office</label>
                        </div>
                    {{-- @endif --}}
                    <div class="row">
                        @isset($dropDownData['states'])
                            <div class="col-md-4 col-lg-4 col-sm-12">
                                <div class="form-group" wire:key='state'>
                                    <x-select label="States List" placeholder="Select State"
                                        wire:model.defer="newUserData.state_code">
                                        @foreach ($dropDownData['states'] as $state)
                                            <x-select.option label="{{ $state['state_name'] }}"
                                                value="{{ $state['state_code'] }}" />
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
