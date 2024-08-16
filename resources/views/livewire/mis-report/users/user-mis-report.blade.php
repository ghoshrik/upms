<div>
    <div class="container-fluid content-inner py-0 mt-3">
        <div class="iq-navbar-header" style="height: 124px;">
            <div class="container-fluid iq-container">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 gap-3">
                    <div class="d-flex flex-column">
                        <h3 class="text-dark">MIS REPORT FOR USERS</h3>
                    </div>
                </div>
            </div>
        </div>
        @section('webtitle', trans('cruds.office.title'))
        <div wire:loading.delay.long>
            <div class="spinner-border text-primary loader-position" role="status"></div>
        </div>
        <div wire:loading.delay.long.class="loading">
            <div x-transition.duration.900ms>
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="container my-5">
                                    <h1 class="text-center mb-4">MIS Report</h1>
                                    <table class="table table-bordered text-center">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Department</th>
                                                <th>Group Count</th>
                                                <th>Office Count</th>
                                                <th>User Count</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($departments as $department)
                                                <tr>
                                                    <td>{{ $department->department_name }}</td>
                                                    <td>{{ $department->group_count }}</td>
                                                    <td>{{ $department->office_count }}</td>
                                                    <td></td> <!-- User count will go here -->
                                                    <td>
                                                        <!-- Button to Open the Modal -->
                                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#detailsModal">
                                                            View
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
