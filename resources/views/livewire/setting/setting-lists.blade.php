<div>
    @section('webtitle', trans('cruds.settings.title'))
    <div wire:loading.delay.long>
        <div class="spinner-border text-primary loader-position" role="status"></div>
    </div>
    <div wire:loading.delay.long.class="loading" x-data="{ formOpen: @entangle('formOpen') }">
        <div x-show="formOpen" x-transition.duration.900ms>
            {{-- @if ($formOpen)
                <livewire:milestone.create-milestone />
            @endif --}}
        </div>
        <style>
            .tab-design{

            }
            .tab-design .tab-head{
                width: 33.33333%;

                box-sizing: border-box;
                display: inline-block;
                margin-right: -0.25em;
                min-height: 1px;
                padding-left: 40px;
                vertical-align: top;
            }
            .tab-design .tab-title{
                padding: 15px 20px 15px 40px;
                margin-bottom: 10px;
                color: #000000;
                /* background: #3F51B5; */
                box-shadow: 0 0 20px rgb(0 0 0 / 10%);
                cursor: pointer;
                position: relative;
                vertical-align: middle;
                font-weight: 700;
                transition: 1s all cubic-bezier(0.075, 0.82, 0.165, 1);

            }
        </style>
        <div x-show="!formOpen" x-transition.duration.500ms>
            <div class="col-md-12 col-lg-12 col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <div x-data="{tabs:['unit','sor','estimate'],activeTabs:'unit',b-color:'#FBC02D'}" class="tab-design">
                            <div class="tab-head">
                                <template x-for="tab in tabs">
                                    <div class="tab-title" :style="{color:$(b-color):activeTabs === tab }" @click="activeTabs=tab">
                                        <span class="light"></span><span x-text="tab"></span>
                                    </div>
                                </template>
                            </div>
                            <div x-show="activeTabs==='unit'">
                                <ul>
                                    <li>
                                        Unit
                                    </li>
                                </ul>
                            </div>
                            <div x-show="activeTabs==='sor'">SOr</div>
                            <div x-show="activeTabs==='estimate'">estimate</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
