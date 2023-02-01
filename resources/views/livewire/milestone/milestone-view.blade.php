<div>
    <style>
        .treeview .btn-default {
            border-color: #e3e5ef;
        }

        .treeview .btn-default:hover {
            background-color: #f7faea;
            color: #bada55;
        }

        .treeview ul {
            list-style: none;
            padding-left: 32px;
        }

        .treeview ul li {
            padding: 50px 0px 0px 35px;
            position: relative;
        }

        .treeview ul li:before {
            content: "";
            position: absolute;
            top: -26px;
            left: -31px;
            border-left: 2px dashed #a2a5b5;
            width: 1px;
            height: 100%;
        }

        .treeview ul li:after {
            content: "";
            position: absolute;
            border-top: 2px dashed #a2a5b5;
            top: 70px;
            left: -30px;
            width: 65px;
        }

        .treeview ul li:last-child:before {
            top: -22px;
            height: 90px;
        }

        .treeview>ul>li:after,
        .treeview>ul>li:last-child:before {
            content: unset;
        }

        .treeview>ul>li:before {
            top: 90px;
            left: 36px;
        }

        .treeview>ul>li:not(:last-child)>ul>li:before {
            content: unset;
        }

        .treeview>ul>li>.treeview__level:before {
            height: 60px;
            width: 60px;
            top: -9.5px;
            background-color: #54a6d9;
            border: 7.5px solid #d5e9f6;
            font-size: 22px;
        }

        .treeview>ul>li>ul {
            padding-left: 34px;
        }

        .treeview__level {
            padding: 7px;
            padding-left: 42.5px;
            display: inline-block;
            border-radius: 5px;
            font-weight: 700;
            border: 1px solid #e3e5ef;
            position: relative;
            z-index: 1;
        }

        .treeview__level:before {
            content: attr(data-level);
            position: absolute;
            left: -27.5px;
            top: -6.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 55px;
            width: 55px;
            border-radius: 50%;
            border: 7.5px solid #eef6d5;
            background-color: #bada55;
            color: #fff;
            font-size: 20px;
        }

        .treeview__level-btns {
            margin-left: 15px;
            display: inline-block;
            position: relative;
        }

        .treeview__level .level-same,
        .treeview__level .level-sub {
            position: absolute;
            display: none;
            transition: opacity 250ms cubic-bezier(0.7, 0, 0.3, 1);
        }

        .treeview__level .level-same.in,
        .treeview__level .level-sub.in {
            display: block;
        }

        .treeview__level .level-same.in .btn-default,
        .treeview__level .level-sub.in .btn-default {
            background-color: #faeaea;
            color: #da5555;
        }

        .treeview__level .level-same {
            top: 0;
            left: 45px;
        }

        .treeview__level .level-sub {
            top: 42px;
            left: 0px;
        }

        .treeview__level .level-remove {
            display: none;
        }

        .treeview__level.selected {
            background-color: #f9f9fb;
            box-shadow: 0px 3px 15px 0px rgba(0, 0, 0, 0.1);
        }

        .treeview__level.selected .level-remove {
            display: inline-block;
        }

        .treeview__level.selected .level-add {
            display: none;
        }

        .treeview__level.selected .level-same,
        .treeview__level.selected .level-sub {
            display: none;
        }

        .treeview .level-title {
            cursor: pointer;
            user-select: none;
        }

        .treeview .level-title:hover {
            text-decoration: underline;
        }

        .treeview--mapview ul {
            justify-content: center;
            display: flex;
        }

        .treeview--mapview ul li:before {
            content: unset;
        }

        .treeview--mapview ul li:after {
            content: unset;
        }
    </style>
    <div class="col-md-12 col-lg-12 col-sm-3">
        <div class="card">
            <div class="card-header">
                <a href="{{route('milestones')}}" class="float-right btn btn-soft-danger btn-sm">back</a>
            </div>
            <div class="card-body">
                <div class="treeview">
                    <ul>
                        @foreach ($milestones as $milestone)
                            <li>
                                <div class="treeview__level" data-level="M">
                                    <span class="level-title">{{$milestone->milestone_name}}</span>
                                    <div class="treeview__level-btns">

                                        <div class="btn btn-default btn-sm level-add">{{$milestone->created_at->format('Y-m-d')}}</div>
                                        <input type="file" class="btn-sm level-add" placeholder="  file..." />
                                        <div class="btn btn-default btn-sm level-add">status</div>

                                    </div>

                                </div>
                                <ul>
                                    @foreach ($milestone->childrenMilestones as $childMilestone)
                                        @include('child_milestone',['child_milestone'=>$childMilestone])
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
