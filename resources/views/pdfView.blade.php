<html>

<head>
    <title>Office List</title>
</head>
<style>
    .container table.responsive-table {
        width: 100%;
        margin: 0 auto;
        clear: both;
        border-collapse: separate;
        border-spacing: 0;
        text-align: left;
        position: relative;
        border-collapse: collapse;
    }

    .container table.responsive-table td,
    th {
        border: 1px solid #999;
        /* padding: 20px; */
    }
</style>

<body>
    <div class="container">
        <table class="responsive-table">
            <caption><b>Office List</b></caption>
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="5%">Office Name</th>
                    <th width="5%">Office Code</th>
                    <th width="5%">Office Address</th>
                    <th width="5%">District Name</th>
                    <th width="3%">Office Level</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($offices ?? '' as $office)
                    <tr>
                        <th scope="row" width="5%">{{ $loop->iteration }}</th>
                        <td width="5%">{{ $office->office_name }}</td>
                        <td width="3%">{{ $office->office_code }}</td>
                        <td width="5%">{{ $office->office_address }}</td>
                        <td width="5%">
                            {{ $office->getDistrictName->district_name }}
                        </td>
                        <td width="3%">
                            @switch($office->level_no)
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
