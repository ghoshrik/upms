<div>
    <style>
         .tree, .tree ul {
            margin:0;
            padding:0;
            list-style:none
        }
         .tree ul {
            margin-left:1em;
            position:relative
        }
        .row:after {
        content: "";
        display: table;
        clear: both;
        }
         .tree ul ul {
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
            /* padding:0 1px; */
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
            top:1em;
            left:0
        }
         .tree ul li:last-child:before {
            background:#fff;
            height:auto;
            top:1em;
            bottom:0
        }
         .indicator {
            margin-right:5px;
        }
         .tree li a {
            text-decoration: none;
            color:#369;
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
            {{-- <div >
                <ul class="list-inline p-0 m-0 w-100">
                    <li>
                        <div >
                            <svg width="20" height="20" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M19,3H5C3.89,3 3,3.89 3,5V9H5V5H19V19H5V15H3V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3M10.08,15.58L11.5,17L16.5,12L11.5,7L10.08,8.41L12.67,11H3V13H12.67L10.08,15.58Z">
                                </path>
                            </svg>
                        </div> --}}

                        <div class="row">
                            <div class="col-md-4 col-lg-4 col-sm-3">
                                <x-input label="Project Id" wire:model="projectId" placeholder="Enter Project No." />

                            </div>
                            <div class="col-md-4 col-lg-4 col-sm-3">
                                <x-textarea wire:model="description" rows="2" label="description"
                                    placeholder="Your description" />
                            </div>
                            <div class="col-md-4 col-lg-4 col-sm-3">
                                <button type="button" wire:click="addMilestone(0)"
                                    class="btn btn-soft-success rounded-pill mt-3">Add</button>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-6">
                                <div
                                    class="iq-timeline1 m-0 d-flex align-items-center justify-content-between position-relative">
                                        @isset($treeView)
                                        <ul class="p-0 m-0 w-100 mt-2 mb-2 ml-2">
                                            {{ printTreeHTML($treeView) }}
                                        </ul>
                                        @endisset
                                </div>
                            </div>
                        </div> --}}

                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-12">
                                @isset($treeView)
                                <ul id="tree1">
                                    @isset($treeView)
                                        <li class="tree">
                                            {{_('level- 0')}}
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
                            print_r('<pre>');
                            print_r($treeView);
                            print_r('</pre>');
                        @endphp
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success rounded-pill float-right">Save</button>
                            </div>
                        </div>
                    {{-- </li>
                </ul>
            </div> --}}

        </x-slot>
    </x-form-section>
</div>

