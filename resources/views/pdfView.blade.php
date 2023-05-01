<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <title>{{$Pdfitle}}</title>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700' rel='stylesheet' />
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css'>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js'></script>
    <style>
        .invoide-header h3 {
            text-align: center;
            background: #41414373;
            padding: 7px 0px;
            border-radius: 3px;
            color: #fff;
            border-bottom: 1px solid #000;
        }
        .table-responsive
	{
		min-height: .01%;
		    overflow: hidden;
			outline: none;
	}
	table{
	    border-collapse: collapse;
    border-spacing: 0;
	background-color: transparent;

	}
	table .table
	{
	width: 100%;
    max-width: 100%;
    margin-bottom: 20px;
	}
	table .table .table-bordered
	{
		border: 1px solid #000000;
	}
	.table>caption+thead>tr:first-child>td, .table>caption+thead>tr:first-child>th, .table>colgroup+thead>tr:first-child>td, .table>colgroup+thead>tr:first-child>th, .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th {
    border-top: 1px solid #000;
	}
	.table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
    border-bottom-width: 2px;
}
.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
    border: 1px solid #000000;
}
.table>thead>tr>th {
    vertical-align: bottom;
    border-bottom: 2px solid #000000;
}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #000000;
}
.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
    border: 1px solid #000000;
}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #000000 !important;
}
    </style>
</head>

<body>
    <div class='container bootdey mt-5'>
        <div class='row invoice row-printable'>
            <div class='col-md-10'>

                <!-- col-lg-12 start here -->
                <div class='panel panel-default plain' id='dash_0'>
                    <!-- Start .panel -->
                    <div class='panel-body p30'>
                        <div class='row'>
                            <div class='col-lg-12'>
                                <div class="row invoide-header">
                                    <div class="col-md-12 col-lg-12 col-xs-6">
                                        <h3>{{$Pdfitle}}</h3>
                                    </div>
                                </div>

                                <div class='invoice-items'>
                                    <div class='table-responsive' style='overflow: hidden; outline: none;'
                                        tabindex='0'>
                                        <table class='table table-bordered' style="table-layout: fixed;width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th class='per2 text-center' width="3%">#</th>
                                                    @isset($ModelList)
                                                    {{-- @for($i = 0; $i < count($ModelList); $i++) --}}
                                                    @foreach ($ModelList as $key => $value)


                                                    <th class='per5 text-center text-wrap' width="{{$value}}">{{$key}}</th>
                                                    {{-- <th class='per5 text-center text-wrap' width="10%">Office Code</th>
                                                    <th class='per5 text-center text-wrap' width="44%">Office Address</th>

                                                    <th class='per5 text-center' width="14%">District</th>
                                                    <th class='per5 text-center' width="7%">Office Level</th> --}}
                                                    {{-- @endfor --}}
                                                    @endforeach
                                                    @endisset
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data ?? '' as $data)
                                                    <tr width="100%">
                                                        <td width="3%">{{ $data['id'] }}</td>
                                                        {{-- Office --}}
                                                        <td class="text-wrap">{{ $data['title'] }}</td>
                                                        @if(array_key_exists('office_code',$data))
                                                        <td class="text-wrap">{{ $data['office_code'] }}</td>
                                                        @endif

                                                        @if(array_key_exists('address',$data))
                                                        <td class="text-wrap">{{ $data['address'] }}</td>
                                                        @endif

                                                        @if(array_key_exists('dist',$data))
                                                        <td class="text-wrap">{{ $data['dist'] }}</td>
                                                        @endif
                                                        @if(array_key_exists('level',$data))
                                                        <td class='text-center' width="7%" class="text-wrap">
                                                            @switch($data['level'])
                                                                @case(1)
                                                                    {{ __('Level 1 Office') }}
                                                                @break

                                                                @case(2)
                                                                    {{ __('Level 2 Office') }}
                                                                @break

                                                                @case(3)
                                                                    {{ __('Level 3 Office') }}
                                                                @break

                                                                @case(4)
                                                                    {{ __('Level 4 Office') }}
                                                                @break

                                                                @case(5)
                                                                    {{ __('Level 5 Office') }}
                                                                @break

                                                                @default
                                                                    {{ __('Level 6 Office') }}
                                                            @endswitch
                                                        </td>
                                                        @endif
                                                        {{-- Offices  --}}

                                                        {{-- User Management  --}}
                                                        @if(array_key_exists('email',$data))
                                                        <td class="text-wrap">{{ $data['email'] }}</td>
                                                        @endif
                                                        @if(array_key_exists('username',$data))
                                                        <td class="text-wrap">{{ $data['username'] }}</td>
                                                        @endif
                                                        @if(array_key_exists('ehrms',$data))
                                                        <td class="text-wrap">{{ $data['ehrms'] }}</td>
                                                        @endif
                                                        @if(array_key_exists('mobile',$data))
                                                        <td class="text-wrap">{{ $data['mobile'] }}</td>
                                                        @endif
                                                        @if(array_key_exists('designation',$data))
                                                        <td class="text-wrap">{{ $data['designation'] }}</td>
                                                        @endif
                                                        @if(array_key_exists('department',$data))
                                                        <td class="text-wrap">{{ $data['department'] }}</td>
                                                        @endif
                                                        @if(array_key_exists('active',$data))
                                                        <td class="text-wrap">
                                                            @switch($data['active'])
                                                                @case(1)
                                                                    {{__('Active')}}
                                                                @break

                                                                @default
                                                                    {{__('Inactive')}}
                                                            @endswitch
                                                        </td>
                                                        @endif
                                                        {{-- User Management  --}}
                                                    </tr>
                                                @endforeach
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- col-lg-12 end here -->
                        </div>
                        <!-- End .row -->
                    </div>
                </div>
                <!-- End .panel -->
            </div>
            <!-- col-lg-12 end here -->
            {{-- <div class="col-md-12 col-lg-12 col-sm-12">
                @isset($pdf)

                <div style="text-align: right;margin-top:5px;">1
                    Page
                    <span class="pdfcrowd-page-number"></span>
                    of
                    <span class="pdfcrowd-page-count" style="font-weight: bold"></span>
                    1 pages
                </div>
                @endisset
            </div> --}}
        </div>
    </div>
</body>
</html>
