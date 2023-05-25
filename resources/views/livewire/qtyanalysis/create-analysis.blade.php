<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div wire:loading.delay.longest.class="loading" class="card-body">
                    <div class="row">
                        <div class="col col-md-4 col-lg-4 col-sm-12 col-xs-12 mb-2">
                            <div class="form-group">
                                {{-- <x-select wire:key="categoryType" label="{{ trans('cruds.estimate.fields.category') }}"
                                    placeholder="Select {{ trans('cruds.estimate.fields.category') }}"
                                    wire:model.defer="selectedCategoryId"
                                    x-on:select="$wire.changeCategory($event.target)">
                                    @foreach ($getCategory as $category)
                                        <x-select.option label="{{ $category['item_name'] }}"
                                            value="{{ $category['id'] }}" />
                                    @endforeach
                                </x-select> --}}
                                <x-select label="Select Project" placeholder="Select one status" :options="[
                                    ['name' => 'height', 'id' => 1],
                                    ['name' => 'weight', 'id' => 2],
                                    ['name' => 'breath', 'id' => 3],
                                ]"
                                    option-label="name" option-value="id" wire:model="Type" />
                            </div>
                            @if ($type)
                                <div>
                                    <x-input wire:model="firstName" label="Name" placeholder="User's first name" />
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
