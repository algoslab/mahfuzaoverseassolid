@extends('supper_admin.layouts.app')
@section('title', config('app.name') . ' - Leave')

@section('style')
    <style>
        .wrap-text {
            white-space: normal !important;
            word-wrap: break-word !important;
            word-break: break-word !important;
        }
    </style>
    <!-- daterangepicker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
                <h3 class="box-title">Leave</h3>
                <h6 class="box-subtitle">This is all Leave List</h6>
            </div>
            <button type="button" class="btn btn-warning addBlogButton" data-toggle="modal" data-target="#modal-center">
                <i class="fa-solid fa-plus"></i> Add Data
            </button>
        </div>

        @include('supper_admin.components.attendanceAndLeave.leave_modal')
        @include('supper_admin.components.attendanceAndLeave.leave_details_modal')

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
                        <th style="">Leave Type</th>
                        <th style="">Shift</th>
                        <th style="">NOD</th>
                        <th style="">Entry Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($leaves as $key =>$bonus)
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
                                           data-target="#leave-details" data-id="{{ $bonus->id }}">
                                            <i class="fa fa-bars"></i> View
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
                            <td class="wrap-text">{{ $bonus->leave_type  }}</td>
                            <td class="wrap-text">{{ $bonus->shift  }}</td>
                            <td class="wrap-text">{{ $bonus->no_of_days  }}</td>
                            <td class="wrap-text">{{ $bonus->created_at->format('F d, Y') }}</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    @section('script')

        <!-- daterangepicker JS -->
        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script>

            function fetchLeaves() {
                $.ajax({
                    url: '{{ route("supper_admin.leaves.index") }}',
                    type: 'GET',
                    success: function (data) {
                        let newBody = $(data).find('#customDataTable tbody').html();
                        $('#customDataTable tbody').html(newBody);
                    },
                    error: function () {
                        console.error('Failed to refresh leave table.');
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

            $('#leave_date').daterangepicker({
                    opens: 'left', // or 'right'
                    autoUpdateInput: true,
                    locale: {
                        format: 'YYYY-MM-DD',
                        separator: ' → ', // change dash to arrow
                        cancelLabel: 'Clear'
                    }
                }, function(start, end) {
                    // Calculate number of days including both start and end
                    let days = end.diff(start, 'days') + 1;
                    // Display it in a paragraph
                    $('#no_of_days').val(days);
                }
            );

            // Optional: Clear on cancel
            $('#leave_date').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
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

                $('#leave_type').on('change', function () {
                    $('#dayDiv').show();
                    const selectedText = $(this).find('option:selected').text();
                    let today = moment().startOf('day').format('YYYY-MM-DD');

                    if (selectedText === 'Half Day Leave') {
                        $('#shiftDiv').show();
                        $('#leave_date').val(today);
                        $('#no_of_days').val(0.5);
                    } else if (selectedText === 'Full Day Leave') {
                        $('#shiftDiv').hide();
                        $('#leave_date').attr('type', 'text');
                        $('#leave_date').val(today+'→'+today);
                        $('#no_of_days').val(1);
                    } else {
                        $('#shiftDiv').hide();
                        $('#no_of_days').val(0);
                    }
                });

                $('#leaveForm').on('submit', function (e) {
                    e.preventDefault();
                    let isEdit = $('#leave_id').val() !== '';
                    let formData = new FormData(this);
                    let id = $('#leave_id').val();
                    const baseUpdateUrl = "{{ url('supper_admin/leaves') }}";

                    let url = isEdit
                        ? `${baseUpdateUrl}/${id}`
                        : `{{ route('supper_admin.leaves.store') }}`;

                    let method = isEdit ? 'POST' : 'POST';
                    if (isEdit) {
                        formData.append('_method', 'PUT');
                    }

                    Swal.fire({
                        title: isEdit ? "Update Leave?" : "Add Leave?",
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
                                        $('#leaveForm')[0].reset();
                                        $('#leave_id').val('');
                                        fetchLeaves();
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function () {
                                    Swal.fire('Error!', 'Failed to save leave.', 'error');
                                }
                            });
                        }
                    });
                });

                $(document).on('click', '.addBlogButton', function () {
                    $('#leaveForm')[0].reset();
                    $('#leave_id').val('');
                    $('#departmentSelect').val('').trigger('change');
                    $('#employeeSelect').empty().append('<option value="" disabled selected>Choose Employee</option>');
                    $('#modalTitle').text('Manage Leave');
                    $('#modal-center').modal('show');

                });

                const storageBaseUrl = "{{ asset('storage') }}/";

                $(document).on('click', '.editBlogButton', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("supper_admin.leaves.edit", ":id") }}'.replace(':id', id);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (res) {
                            let createdDate = moment(res.created_at).format('YYYY-MM-DD');
                            $('#modalTitle').text('Leave Details');
                            $('#emp_name').text(res.employee.first_name + ' ' + res.employee.last_name);
                            $('#department').text(res.department.name);
                            $('#type').text(res.leave_type);
                            $('#leave_shift').text(res.shift);
                            $('#nod').text(res.no_of_days);
                            $('#entry_date').text(createdDate);
                            if (res.employee.photo) {
                                $('#preview').attr('src', storageBaseUrl + res.photo);
                                $('#preview').show();
                            } else {
                                console.log('No image path found');  // Log if no image is found
                                $('#preview').attr('src', '');
                                $('#preview').hide();
                            }
                            let leaveDatesHtml = '';
                            res.leave_dates.forEach(function (date) {
                                let formattedDate = moment(date.leave_date).format('dddd, Do [of] MMMM YYYY');
                                leaveDatesHtml += `
            <li class="d-flex align-items-center gap-2">
                <button type="button" class="dropdown-item text-danger deleteDateBtn p-0" data-id="${date.id}">
                    <i class="fa fa-trash"></i>
                </button>
                - <label>${date.leave_date}</label> (${formattedDate})
            </li>`;
                            });
                            $('#leaveDatesList').html(leaveDatesHtml);

                            $('#leave-details').modal('show');
                        },
                        error: function () {
                            Swal.fire('Error', 'Could not load leave data.', 'error');
                        }
                    });
                });

                $(document).on('click', '.deleteBonusBtn', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("supper_admin.leaves.destroy", ":id") }}'.replace(':id', id);

                    Swal.fire({
                        title: 'Delete Leave?',
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
                                        fetchLeaves();
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function () {
                                    Swal.fire('Error!', 'Failed to delete the leave.', 'error');
                                }
                            });
                        }
                    });
                });

                $(document).on('click', '.deleteDateBtn', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("supper_admin.leave-date.withdraw", ":id") }}'.replace(':id', id);

                    Swal.fire({
                        title: 'Yes, withdraw it!',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Withdraw'
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
                                        Swal.fire('Success!', response.message, 'success');
                                        window.location.reload();
                                        fetchLeaves();
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function () {
                                    Swal.fire('Error!', 'Failed to withdraw the leave.', 'error');
                                }
                            });
                        }
                    });
                });
            });
        </script>

    @endsection
@endsection
