@extends('supper_admin.layouts.app')
@section('title', config('app.name') . ' - Attendance')

@section('style')
    <style>
        .wrap-text {
            white-space: normal !important;
            word-wrap: break-word !important;
            word-break: break-word !important;
        }
    </style>
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
                <h3 class="box-title">Attendance</h3>
                <h6 class="box-subtitle">This is all Attendance List</h6>
            </div>
            <button type="button" class="btn btn-warning addBlogButton" data-toggle="modal" data-target="#modal-center">
                <i class="fa-solid fa-plus"></i> Add Data
            </button>
        </div>

        @include('supper_admin.components.attendanceAndLeave.attendance_modal')

        <div class="box-body">
            <div class="table-responsive">
                <table id="customDataTable" style="table-layout: fixed; width: 100%;"
                       class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                    <thead>
                    <tr>
                        <th style="">Action</th>
                        <th style="">DB:ID</th>
                        <th style="">Employee</th>
                        <th style="">Department</th>
                        <th style="">Date</th>
                        <th style="">In</th>
                        <th style="">Out</th>
                        <th style="">Entry Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($attendances as $key =>$bonus)
                        <tr>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bars"></i> Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <!-- Edit Button inside Dropdown -->
                                        <a href="#" class="dropdown-item editBlogButton" data-toggle="modal"
                                           data-target="#modal-center" data-id="{{ $bonus->id }}">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>

                                        <!-- Delete Form inside Dropdown -->
                                        <button type="button"
                                                class="dropdown-item text-danger deleteBonusBtn"
                                                data-id="{{ $bonus->id }}">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </td>

                            <td>{{ $key + 1 }}</td>
                            <td class="wrap-text">{{$bonus->employee ? $bonus->employee->first_name : '' }} {{$bonus->employee ? $bonus->employee->last_name : '' }}</td>
                            <td class="wrap-text">{{$bonus->department ? $bonus->department->name : '' }}</td>
                            <td class="wrap-text">{{ $bonus->date  }}({{ $bonus->date_details  }})</td>
                            <td class="wrap-text">{{ $bonus->check_in  }}</td>
                            <td class="wrap-text">{{ $bonus->check_out  }}</td>
                            <td class="wrap-text">{{ $bonus->created_at->format('F d, Y') }}</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    @section('script')
        <script>

            function fetchAttendances() {
                $.ajax({
                    url: '{{ route("supper_admin.attendances.index") }}',
                    type: 'GET',
                    success: function (data) {
                        let newBody = $(data).find('table tbody').html();
                        $('#customDataTable tbody').html(newBody);
                    },
                    error: function () {
                        console.error('Failed to refresh attendance table.');
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
                function fetchEmployees(departmentId, selectedEmployeeId) {
                    $.ajax({
                        url: "{{ route('admin.employee.active') }}",
                        method: "GET",
                        data: {department_id: departmentId}, // Pass department_id to filter employees
                        success: function (data) {
                            let select = $('#employeeSelect');
                            select.empty();
                            select.append('<option value="" disabled selected>Choose Employee</option>');
                            data.forEach(function (employee) {
                                let selected = employee.id === selectedEmployeeId ? 'selected' : '';
                                select.append('<option value="' + employee.id + '" ' + selected + '>' +
                                    employee.first_name + ' - ' + employee.last_name +
                                    '</option>');
                            });

                            // Ensure the item dropdown value is updated after population
                            select.val(selectedEmployeeId).trigger('change');  // Set selected employee
                        },
                        error: function (xhr) {
                            console.error("Failed to fetch employees :", xhr);
                        }
                    });
                }

                // Trigger the fetchEmployees function when a category is selected
                $('#departmentSelect').on('change', function () {
                    const departmentId = $(this).val();
                    if (departmentId) {
                        fetchEmployees(departmentId);  // Fetch employee based on the selected department
                    } else {
                        $('#employeeSelect').empty().append('<option value="" disabled selected>Choose Employee</option>');
                    }
                });

                $('#attendanceForm').on('submit', function (e) {
                    e.preventDefault();
                    let isEdit = $('#attendance_id').val() !== '';
                    let formData = new FormData(this);
                    let id = $('#attendance_id').val();
                    const baseUpdateUrl = "{{ url('supper_admin/attendances') }}";

                    let url = isEdit
                        ? `${baseUpdateUrl}/${id}`
                        : `{{ route('supper_admin.attendances.store') }}`;

                    let method = isEdit ? 'POST' : 'POST';
                    if (isEdit) {
                        formData.append('_method', 'PUT');
                    }

                    Swal.fire({
                        title: isEdit ? "Update Attendance?" : "Add Attendance?",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonText: "Yes, proceed"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                type: method,
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function (response) {
                                    if (response.status === 'success') {
                                        $('#modal-center').modal('hide');
                                        Swal.fire('Success!', response.message, 'success');
                                        $('#attendanceForm')[0].reset();
                                        $('#attendance_id').val('');
                                        fetchAttendances();
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function () {
                                    Swal.fire('Error!', 'Failed to save attendance.', 'error');
                                }
                            });
                        }
                    });
                });

                $(document).on('click', '.addBlogButton', function () {
                    $('#attendanceForm')[0].reset();
                    $('#attendance_id').val('');
                    $('#departmentSelect').val('').trigger('change');
                    $('#employeeSelect').empty().append('<option value="" disabled selected>Choose Employee</option>');
                    $('#preview').attr('src', '').hide();
                    $('#modalTitle').text('Manage Attendance');
                    $('#modal-center').modal('show');

                });

                $(document).on('click', '.editBlogButton', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("supper_admin.attendances.edit", ":id") }}'.replace(':id', id);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (res) {
                            $('#attendance_id').val(id);
                            $('#date').val(res.date);
                            $('#check_in').val(res.check_in);
                            $('#check_out').val(res.check_out);
                            $('#note').val(res.note);
                            $('#modalTitle').text('Edit attendance');
                            $('#departmentSelect').val(res.department_id).trigger('change');
                            $('#employeeSelect').val(res.employee_id).trigger('change');
                            fetchEmployees(res.department_id, res.employee_id);
                            $('#modal-center').modal('show');

                        },
                        error: function () {
                            Swal.fire('Error', 'Could not load attendance data.', 'error');
                        }
                    });
                });

                $(document).on('click', '.deleteBonusBtn', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("supper_admin.attendances.destroy", ":id") }}'.replace(':id', id);

                    Swal.fire({
                        title: 'Delete Attendance?',
                        text: "This action cannot be undone.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Delete'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                type: 'POST',
                                data: {
                                    _method: 'DELETE',
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function (response) {
                                    if (response.status === 'success') {
                                        Swal.fire('Deleted!', response.message, 'success');
                                        fetchAttendances();
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function () {
                                    Swal.fire('Error!', 'Failed to delete the attendance.', 'error');
                                }
                            });
                        }
                    });
                });
            });
        </script>

    @endsection
@endsection
