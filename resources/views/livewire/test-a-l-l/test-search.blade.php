<div>
    <!--Search problem -->
    <!--
        error:
        1)search query typeing number error not find search result.
        success:
        1)second time type sor number exact number typing then working properly.
        2)proper number typing finish then press tab on keyboard
        3)properly woking all details on typeing number data value, Item_details,qty,and cost
        4)increase and decrease quantity amount properly calculate value and show result on total amount

    -->
    <!--Search problem -->

    <style>
        .dropdown {
            position: relative;
            /* display: inline-block; */
        }

        .dropdown .dropdown-content {
            display: none;
            position: absolute;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
            min-width: 100%;
            background-color: #f9f9f9;
        }

        .dropdown .dropdown-content a {
            color: #000000;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        /* .dropdown .dropdown-content {
            display: block;
        } */
    </style>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div wire:loading.delay.longest.class="loading" class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-lg-6">
                            <div class="form-group">
                                <label for="search_query">Search Text</label>
                                <div class="dropdown ">
                                    <input type="text" wire:model="search_query" wire:keypress="searchWord"
                                        value="{{ $search_query }}" wire:keydown.escape="reset"
                                        wire:keydown.tab="{{ $search_query ? 'SearchFetch' : '' }}"
                                        class="form-control dropbtn" placeholder="Search sor number" />
                                    @if (count($searchResult) > 0)
                                        <div class="dropdown-content"
                                            style="display:{{ count($searchResult) > 0 ? 'block' : 'none' }}">
                                            @foreach ($searchResult as $list)
                                                <a href="#"
                                                    wire:keydown.tab="{{ $list->Item_details }}">{{ $list->Item_details }}</a>
                                                {{-- <a href="#">Link 1</a> --}}
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if ($searchData)
                            <div class="col-md-2 col-sm-2 col-lg-2">
                                <div class="form-group">
                                    <label>Unit</label>
                                    <input type="number" min="0" wire:model="qty" class="form-control"
                                        value="{{ $qty }}" wire:keyup="calculateValue">
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2 col-lg-2">
                                <div class="form-group">
                                    <label>Cost</label>
                                    <input type="number" min="0" wire:model="cost" class="form-control" disabled
                                        value="{{ $cost }}">
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2 col-lg-2">
                                <div class="form-group">
                                    <label>Total Amount</label>
                                    <input type="number" min="0" class="form-control" disabled
                                        value="{{ $total_amount }}">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-6 col-lg-12">
                                <div class="form-group">
                                    <textarea name="" id="" readonly cols="5" rows="5" class="form-control">{{ $desc }}</textarea>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
