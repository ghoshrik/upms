<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Office Name</th>
            <th>Office Code</th>
            <th>Office Address</th>
            <th>District Name</th>
            <th>Office Level</th>
        </tr>
    </thead>
    <tbody>
        @foreach($offices ?? '' as $office)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$office->office_name}}</td>
                <td>{{$office->office_code}}</td>
                <td>{{$office->office_address}}</td>
                <td>{{$office->getDistrictName->district_name}}</td>
                <td>{{$office->level_no}}</td>
            </tr>
        @endforeach
        {{-- @dd($offices) --}}

    </tbody>
</table>
