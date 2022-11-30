<div>
    <div x-show="formOpen" class="row" x-transition.duration.500ms>
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>

                <div wire:loading.class="loading" class="card-body">
                    <div class="row">
                        <form>
                            <div class="row">
                                <div class="col col-md-8 col-lg-8 mb-2">
                                    <x-textarea wire:model="comment" rows="2"
                                        label="{{ trans('cruds.estimate.fields.description') }}"
                                        placeholder="Your project {{ trans('cruds.estimate.fields.description') }}" />
                                </div>
                                <div class="col col-md-4 col-lg-4 mb-2">
                                    <div class="form-group">
                                        <x-select wire:key="category" label="{{ trans('cruds.estimate.fields.category') }}"
                                            placeholder="Select {{ trans('cruds.estimate.fields.category') }}"
                                            x-on:select="$wire.changeCategory($event.target)">
                                            @foreach ($getCategory as $category)
                                                <x-select.option label="{{ $category['item_name'] }}"
                                                    value="{{ $category['id'] }}" />
                                            @endforeach
                                        </x-select>
                                    </div>
                                </div>
                            </div>
                            @if (!empty($estimateData))
                                @if ($estimateData['item_name'] == 'SOR')
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <x-select wire:key="departmant"
                                                    label="{{ trans('cruds.estimate.fields.dept') }}"
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
                                                <x-select label="{{ trans('cruds.estimate.fields.category') }}"
                                                    placeholder="Select {{ trans('cruds.estimate.fields.category') }}"
                                                    wire:model.defer="estimateData.dept_category_id"
                                                    x-on:select="$wire.getVersion()">
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
                                                <x-select label="{{ trans('cruds.estimate.fields.version') }}"
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
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <x-select label="Select {{ trans('cruds.estimate.fields.sor') }}"
                                                    placeholder="Select {{ trans('cruds.estimate.fields.sor') }}"
                                                    wire:model.defer="estimateData.item_number"
                                                    x-on:select="$wire.getItemDetails()">
                                                    @isset($this->fatchDropdownData['items_number'])
                                                        @foreach ($this->fatchDropdownData['items_number'] as $key => $item)
                                                            <x-select.option label="{{ $item['Item_details'] }}"
                                                                value="{{ $key }}" />
                                                        @endforeach
                                                    @endisset
                                                </x-select>
                                            </div>
                                        </div>
                                    </div>
                                    @if (!empty($estimateData['item_number']))
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <x-input label="{{ trans('cruds.estimate.fields.description') }}"
                                                    placeholder="{{ trans('cruds.estimate.fields.description') }}" wire:model.defer="estimateData.description"/>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <x-input label="{{ trans('cruds.estimate.fields.quantity') }}"
                                                    placeholder="{{ trans('cruds.estimate.fields.quantity') }}" wire:model.defer="estimateData.qty" wire:keyup="calculateValue"/>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <x-input label="{{ trans('cruds.estimate.fields.per_unit_cost') }}"
                                                    placeholder="{{ trans('cruds.estimate.fields.per_unit_cost') }}" wire:model.defer="estimateData.rate"/>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <x-input label="{{ trans('cruds.estimate.fields.cost') }}"
                                                    placeholder="{{ trans('cruds.estimate.fields.cost') }}" wire:model.defer="estimateData.total_amount"/>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endif
                            @endif


                            <div class="row">
                                <div class="col">
                                    <div class="form-group float-right">
                                        <button @click="formOpen=false" type="button"
                                            class="btn btn-danger rounded-pill ">{{ trans('global.cancel_btn') }}</button>
                                        <button type="submit"
                                            class="{{ trans('global.data_store_btn_color') }} ">{{ trans('global.data_store_btn') }}</button>
                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div  class="col-md-12 col-lg-12"  x-transition.duration.500ms>
        <div class="card overflow-hidden">
        <div class="card-header d-flex justify-content-between flex-wrap">
            <div class="header-title">
                <h4 class="card-title mb-2">Enterprise Clients</h4>
                <p class="mb-0">
                    <svg class ="me-2" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="#3a57e8" d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z" />
                    </svg>
                    15 new acquired this month
                </p>
            </div>
            <div class="dropdown">
                <span class="dropdown-toggle" id="dropdownMenuButton7" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                </span>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton7">
                    <a class="dropdown-item " href="javascript:void(0);">Action</a>
                    <a class="dropdown-item " href="javascript:void(0);">Another action</a>
                    <a class="dropdown-item " href="javascript:void(0);">Something else here</a>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive mt-4">
                <table id="basic-table" class="table table-striped mb-0" role="grid">
                    <thead>
                    <tr>
                        <th>COMPANIES</th>
                        <th>CONTACTS</th>
                        <th>ORDER</th>
                        <th>COMPLETION</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img class="bg-soft-primary rounded img-fluid avatar-40 me-3" src="{{asset('images/shapes/01.png')}}" alt="profile">
                                <h6>Addidis Sportwear</h6>
                            </div>
                        </td>
                        <td>
                            <div class="iq-media-group iq-media-group-1">
                                <a href="#" class="iq-media-1">
                                <div class="icon iq-icon-box-3 rounded-pill">SP</div>
                                </a>
                                <a href="#" class="iq-media-1">
                                <div class="icon iq-icon-box-3 rounded-pill">PP</div>
                                </a>
                                <a href="#" class="iq-media-1">
                                <div class="icon iq-icon-box-3 rounded-pill">MM</div>
                                </a>
                            </div>
                        </td>
                        <td>$14,000</td>
                        <td>
                            <div class="d-flex align-items-center mb-2">
                                <h6>60%</h6>
                            </div>
                            <div class="progress bg-soft-primary shadow-none w-100" style="height: 4px">
                                <div class="progress-bar bg-primary" data-toggle="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img class="bg-soft-primary rounded img-fluid avatar-40 me-3" src="{{asset('images/shapes/05.png')}}" alt="profile">
                                <h6>Netflixer Platforms</h6>
                            </div>
                        </td>
                        <td>
                            <div class="iq-media-group iq-media-group-1">
                                <a href="#" class="iq-media-1">
                                <div class="icon iq-icon-box-3 rounded-pill">SP</div>
                                </a>
                                <a href="#" class="iq-media-1">
                                <div class="icon iq-icon-box-3 rounded-pill">PP</div>
                                </a>
                            </div>
                        </td>
                        <td>$30,000</td>
                        <td>
                            <div class="d-flex align-items-center mb-2">
                                <h6>25%</h6>
                            </div>
                            <div class="progress bg-soft-primary shadow-none w-100" style="height: 4px">
                                <div class="progress-bar bg-primary" data-toggle="progress-bar" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img class="bg-soft-primary rounded img-fluid avatar-40 me-3" src="{{asset('images/shapes/02.png')}}" alt="profile">
                                <h6>Shopifi Stores</h6>
                            </div>
                        </td>
                        <td>
                            <div class="iq-media-group iq-media-group-1">
                                <a href="#" class="iq-media-1">
                                <div class="icon iq-icon-box-3 rounded-pill">PP</div>
                                </a>
                                <a href="#" class="iq-media-1">
                                <div class="icon iq-icon-box-3 rounded-pill">TP</div>
                                </a>
                            </div>
                        </td>
                        <td>$8,500</td>
                        <td>
                            <div class="d-flex align-items-center mb-2">
                                <h6>100%</h6>
                            </div>
                            <div class="progress bg-soft-success shadow-none w-100" style="height: 4px">
                                <div class="progress-bar bg-success" data-toggle="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img class="bg-soft-primary rounded img-fluid avatar-40 me-3" src="{{asset('images/shapes/03.png')}}" alt="profile">
                                <h6>Bootstrap Technologies</h6>
                            </div>
                        </td>
                        <td>
                            <div class="iq-media-group iq-media-group-1">
                                <a href="#" class="iq-media-1">
                                <div class="icon iq-icon-box-3 rounded-pill">SP</div>
                                </a>
                                <a href="#" class="iq-media-1">
                                <div class="icon iq-icon-box-3 rounded-pill">PP</div>
                                </a>
                                <a href="#" class="iq-media-1">
                                <div class="icon iq-icon-box-3 rounded-pill">MM</div>
                                </a>
                                <a href="#" class="iq-media-1">
                                <div class="icon iq-icon-box-3 rounded-pill">TP</div>
                                </a>
                            </div>
                        </td>
                        <td>$20,500</td>
                        <td>
                            <div class="d-flex align-items-center mb-2">
                                <h6>100%</h6>
                            </div>
                            <div class="progress bg-soft-success shadow-none w-100" style="height: 4px">
                                <div class="progress-bar bg-success" data-toggle="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img class="bg-soft-primary rounded img-fluid avatar-40 me-3" src="{{asset('images/shapes/04.png')}}" alt="profile">
                                <h6>Community First</h6>
                            </div>
                        </td>
                        <td>
                            <div class="iq-media-group iq-media-group-1">
                                <a href="#" class="iq-media-1">
                                <div class="icon iq-icon-box-3 rounded-pill">MM</div>
                                </a>
                            </div>
                        </td>
                        <td>$9,800</td>
                        <td>
                            <div class="d-flex align-items-center mb-2">
                                <h6>75%</h6>
                            </div>
                            <div class="progress bg-soft-primary shadow-none w-100" style="height: 4px">
                                <div class="progress-bar bg-primary" data-toggle="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
</div>
