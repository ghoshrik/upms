<div class="col-md-12 col-lg-12" x-transition.duration.500ms>
    <div class="card overflow-hidden">
        <div class="card-header d-flex justify-content-between flex-wrap">
            <div class="header-title">
                <h4 class="card-title mb-2">Added Estimates List</h4>
            </div>
        </div>
        <div>
            <div class="row m-2">
                <div class="col col-md-9 col-lg-9 mb-2">
                    {{-- <button class="btn btn-soft-info rounded-pill ">
                        {{ trans('cruds.estimate.fields.total_on_selected') }}
                    </button> --}}
                    <div class="row m-2">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                            <button type="button" class="btn btn-soft-primary">Success</button>
                        </div>
                    </div>
                </div>
                <div class="col col-md-3 col-lg-3 mt-2">
                    <div class="btn-group float-right" role="group" aria-label="Basic example">
                        <button type="button"
                            class="btn btn-soft-primary">{{ trans('cruds.estimate.fields.total_on_selected') }}</button>
                        <button type="button" class="btn btn-soft-info">
                            <span class="btn-inner">
                                <x-lucide-sheet class="w-4 h-4 text-gray-500" />
                            </span>
                            {{ trans('cruds.estimate.fields.export_word') }}</button>
                    </div>
                    {{-- <button class="btn btn-soft-primary rounded-pill float-right">
                        <span class="btn-inner">
                            <x-lucide-sheet class="w-4 h-4 text-gray-500" />
                        </span>
                        {{ trans('cruds.estimate.fields.export_word') }}
                    </button> --}}
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive mt-4">
                <table id="basic-table" class="table table-striped mb-0" role="grid">
                    <thead>
                        <tr>
                            <th></th>
                            <th>{{ trans('cruds.estimate.fields.id_helper') }}</th>
                            <th>{{ trans('cruds.estimate.fields.item_number') }}</th>
                            <th>{{ trans('cruds.estimate.fields.description') }}</th>
                            <th>{{ trans('cruds.estimate.fields.quantity') }}</th>
                            <th>{{ trans('cruds.estimate.fields.per_unit_cost') }}</th>
                            <th>{{ trans('cruds.estimate.fields.cost') }}</th>
                            <th>{{ trans('cruds.estimate.fields.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($addedEstimatesData as $key => $addedEstimate)
                            <tr>
                                <td>
                                    <x-checkbox id="checkbox" wire:model="level"
                                        value="{{ $addedEstimate['array_id'] }}" />
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ chr($key + 64) }}
                                    </div>
                                </td>
                                <td>
                                    @if ($addedEstimate['sor_item_number'])
                                        {{ $addedEstimate['sor_item_number'] }}
                                    @else
                                        --
                                    @endif
                                </td>
                                <td>
                                    @if ($addedEstimate['sor_item_number'])
                                        {{ $addedEstimate['description'] }}
                                    @else
                                        {{ $addedEstimate['other_name'] }}
                                    @endif

                                </td>
                                <td>
                                    {{ $addedEstimate['qty'] }}
                                </td>
                                <td>
                                    {{ $addedEstimate['rate'] }}
                                </td>
                                <td>
                                    {{ $addedEstimate['total_amount'] }}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-soft-danger btn-sm">
                                        <span class="btn-inner">
                                            <x-lucide-trash-2 class="w-4 h-4 text-gray-500" /> Delete
                                        </span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-body">
            <button type="button" wire:click='addEstimate'
                class="btn btn-success rounded-pill float-right">Save</button>
        </div>
    </div>
</div>
