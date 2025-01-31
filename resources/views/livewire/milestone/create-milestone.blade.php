<div>
    <style>
        .tree,
        .tree ul {
            margin: 0;
            padding: 0;
            list-style: none
        }

        .tree ul {
            margin-left: 1em;
            /* position:relative */
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* .tree ul ul {
            margin-left:.5em
            width:100%;padding-right:0;
        }
         .tree ul:before {
            content:"";
            display:block;
            width:100%;
            position:absolute;
            top:0;
            bottom:0;
            left:0;
            border-left:1px solid
        }
         .tree li {
            margin:0;
            line-height:2em;
            color:#369;
            font-weight:700;
            position:relative
        }
        .tree ul li:before {
            content:"";
            display:block;
            width:8px;
            height:0;
            border-top:1px solid;
            margin-top:-1px;
            position:absolute;
            top:1.5em;
            left:0
        }
         .tree ul li:last-child:before {
            background:#fff;
            height:auto;
            top:1em;
            bottom:0
        }*/
        .indicator {
            margin-right: 5px;
        }

        .tree li a {
            text-decoration: none;
            color: #369;
        }

        /* .tree li button, .tree li button:active, .tree li button:focus {
            text-decoration: none;
            color:#369;
            border:none;
            background:transparent;
            margin:0px 0px 0px 0px;
            padding:0px 0px 0px 0px;
            outline: 0;
        } */
    </style>
    <x-form-section submit='store'>
        <x-slot name='form'>
            <div class="row">
                <div class="col-md-4 col-lg-4 col-sm-3">
                    {{-- <x-input label="Project Id" wire:model="projectId" placeholder="Enter Project No." /> --}}
                    <x-select label="{{ trans('cruds.milestone.fields.project_num') }}"
                    placeholder="Select {{ trans('cruds.milestone.fields.project_num') }}"
                    wire:model.defer="projectId" x-on:select="$wire.changeProject()">

                        @foreach ($projects_number as $projects)
                            <x-select.option label="{{ $projects['estimate_id'] }}" value="{{ $projects['estimate_id'] }}" />
                        @endforeach
                    </x-select>
                </div>
                @if($this->description)
                <div class="col-md-6 col-lg-6 col-sm-3">
                    <x-textarea wire:model="description" rows="2" label="{{ trans('cruds.milestone.fields.desc') }}"
                    placeholder="{{ trans('cruds.milestone.fields.desc') }}" readonly />
                </div>
               @endif
                <div class="col-md-2 col-lg-2 col-sm-3">
                    <button type="button" wire:click="addMilestone(0)"
                        class="btn btn-soft-success rounded-pill mt-3">Add</button>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    @isset($treeView)
                        <ul id="tree1">
                            @isset($treeView)
                                <li>
                                    <ul>
                                        {{ printTreeHTML($treeView) }}
                                    </ul>
                                </li>
                            @endisset
                        </ul>
                    @endisset
                </div>
            </div>

            @php
                // print_r('<pre>');
                // print_r($treeView);
                // print_r('</pre>');

                // echo "Before:" . PHP_EOL;
                // print_r($treeView);

                // echo "After:" . PHP_EOL;
                // print_r('<pre>');
                // print_r($treeView);
                // print_r('</pre>');
                // print_r(removeUselessArrays($treeView));
            @endphp
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-success rounded-pill float-right">Save</button>
                </div>
            </div>
        </x-slot>
    </x-form-section>
</div>
