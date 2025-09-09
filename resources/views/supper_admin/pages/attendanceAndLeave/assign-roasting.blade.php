@extends('supper_admin.layouts.app')
@section('title', config('app.name') . ' - Assign Roasting')

@section('style')
    <style>
        .wrap-text {
            white-space: normal !important;
            word-wrap: break-word !important;
            word-break: break-word !important;
        }
    </style>
    <!-- daterangepicker CSS -->
    @endsection

@section('content')

    @if (session('status'))
        <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content text-center">
                    <div class="modal-header border-0">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if (session('status') == 'success')
                            <i class="fas fa-check-circle text-success"></i>
                            <h5 class="mt-3 text-success">Success</h5>
                        @else
                            <i class="fas fa-times-circle text-danger"></i>
                            <h5 class="mt-3 text-danger">Error</h5>
                        @endif
                        <p class="mt-2">{{ session('message') }}</p>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="box">
        <!-- Header Section -->
        <div class="box-header with-border d-flex justify-content-between align-items-center">
            <div>
                <h3 class="box-title">Assign Roasting</h3>
                <h6 class="box-subtitle">This is all assign roasting List</h6>
            </div>
        </div>

        <div class="box-body">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Choose department</label>
                            <select name="department_id" id="departmentSelect" class="form-control" required>
                                <option value="" disabled selected>Choose Department</option>
                            </select>
                            </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="customDataTable" style="table-layout: fixed; width: 100%;"
                       class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                    <thead>
                    <tr>
                        <th style="">DB:ID</th>
                        <th style="">Employee Name</th>
                        <th style="">Employee ID</th>
                        <th style="">Department</th>
                        <th style="">Designation</th>
                        <th style="">Roasting Option</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($employees as $key =>$bonus)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td class="wrap-text">{{$bonus->first_name}} {{$bonus->last_name}}</td>
                            <td>{{$bonus->employee_code}}</td>
                            <td class="wrap-text">{{$bonus->department ? $bonus->department->name : '' }}</td>
                            <td class="wrap-text">{{$bonus->designation ? $bonus->designation->name : '' }}</td>
                            <td>
                                <select name="roster_id"
                                        id="rosterSelect_{{ $bonus->id }}"
                                        class="form-control"
                                        onchange="update_employee_roasting({{ $bonus->id }}, this)">
                                    <option value="">Select Roster</option>
                                    @foreach($rosters as $roster)
                                        <option value="{{ $roster->id }}"
                                            {{ $bonus->roster_id == $roster->id ? 'selected' : '' }}>
                                            {{ $roster->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    @section('script')
        <script>
            function fetchAssignRoasting(departmentId = null) {
                $.ajax({
                    url: '{{ route("supper_admin.roastings.index") }}',
                    type: 'GET',
                    data: {department_id: departmentId}, // Pass department_id to filter employees
                    success: function (data) {
                        let newBody = $(data).find('#customDataTable tbody').html();
                        $('#customDataTable tbody').html(newBody);
                    },
                    error: function () {
                        console.error('Failed to refresh assign roasting table.');
                    }
                });
            }

            $('#modal-center').on('shown.bs.modal', function () {
                $('.wrapper').removeAttr('aria-hidden');
            });

            // When the modal is hidden
            $('#modal-center').on('hidden.bs.modal', function () {
                $('.wrapper').attr('aria-hidden', 'true');
            });

            function update_employee_roasting(employeeId, selectElement) {
                const selectedRosterId = selectElement.value;

                $.ajax({
                    url: `/supper_admin/roastings/${employeeId}`, // adjust route
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        roster_id: selectedRosterId
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            Swal.fire('Success!', response.message, 'success');
                            // Get currently selected department ID
                            const selectedDeptId = $('#departmentSelect').val();

                            // Refresh the employee list filtered by selected department
                            if (selectedDeptId) {
                                fetchAssignRoasting(selectedDeptId);
                            } else {
                                // If no department selected, you can reload all employees or handle accordingly
                                fetchAssignRoasting();
                            }
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error!', 'Failed to assign roasting.', 'error');
                    }
                });
            }

            $(document).ready(function () {

                fetchDepartments();

                function fetchDepartments() {
                    $.ajax({
                        url: "{{ route('admin.department.active') }}",
                        method: "GET",
                        success: function (data) {
                            let select = $('#departmentSelect');
                            select.empty();
                            select.append('<option value="" disabled selected>Choose Department</option>');

                            data.forEach(function (department) {
                                select.append(
                                    '<option value="' + department.id + '">' +
                                    department.name +
                                    '</option>'
                                );
                            });
                        },
                        error: function (xhr) {
                            console.error("Failed to fetch departments:", xhr);
                        }
                    });
                }

                // Fetch Countries based on Continent

                // Trigger the fetchEmployees function when a category is selected
                $('#departmentSelect').on('change', function () {
                    const departmentId = $(this).val();
                    if (departmentId) {
                        fetchAssignRoasting(departmentId);  // Fetch employee based on the selected department
                    }
                });
            });
        </script>

    @endsection
@endsection
