@extends('supper_admin.layouts.app')
@section('title', config('app.name') . ' - Inc & Dec')

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
                <h3 class="box-title">Inc & Dec</h3>
                <h6 class="box-subtitle">This is all Inc & Dec List</h6>
            </div>
            <button type="button" class="btn btn-warning addBlogButton" data-toggle="modal" data-target="#modal-center">
                <i class="fa-solid fa-plus"></i> Add Data
            </button>
        </div>

        @include('supper_admin.components.payroll.inc_and_dec_modal')

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
                        <th style="">Start Month</th>
                        <th style="">Impression</th>
                        <th style="">Type</th>
                        <th style="">Amount</th>
                        <th style="">Entry Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($incAndDecs as $key =>$bonus)
                        <tr>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bars"></i> Action
                                    </button>
                                    <div class="dropdown-menu">

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
                            <td class="wrap-text">{{ $bonus->start_month  }}</td>
                            <td class="wrap-text">{{ $bonus->impression_type  }}</td>
                            <td class="wrap-text">{{ $bonus->amount_type  }}</td>
                            <td class="wrap-text">{{ $bonus->amount  }}</td>
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

            function fetchIncAnddecs() {
                $.ajax({
                    url: '{{ route("supper_admin.inc-and-deces.index") }}',
                    type: 'GET',
                    success: function (data) {
                        let newBody = $(data).find('table tbody').html();
                        $('#customDataTable tbody').html(newBody);
                    },
                    error: function () {
                        console.error('Failed to refresh inc and dec table.');
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

                $('#incAndDecForm').on('submit', function (e) {
                    e.preventDefault();
                    let isEdit = $('#inc_and_dec_id').val() !== '';
                    let formData = new FormData(this);
                    let id = $('#inc_and_dec_id').val();
                    const baseUpdateUrl = "{{ url('supper_admin/inc-and-deces') }}";

                    let url = isEdit
                        ? `${baseUpdateUrl}/${id}`
                        : `{{ route('supper_admin.inc-and-deces.store') }}`;

                    let method = isEdit ? 'POST' : 'POST';
                    if (isEdit) {
                        formData.append('_method', 'PUT');
                    }

                    Swal.fire({
                        title: isEdit ? "Update Inc And Dec?" : "Add Inc And Dec?",
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
                                        $('#incAndDecForm')[0].reset();
                                        $('#inc_and_dec_id').val('');
                                        fetchIncAnddecs();
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function () {
                                    Swal.fire('Error!', 'Failed to save inc and dec.', 'error');
                                }
                            });
                        }
                    });
                });

                $(document).on('click', '.addBlogButton', function () {
                    $('#incAndDecForm')[0].reset();
                    $('#inc_and_dec_id').val('');
                    $('#departmentSelect').val('').trigger('change');
                    $('#employeeSelect').empty().append('<option value="" disabled selected>Choose Employee</option>');
                    $('#preview').attr('src', '').hide();
                    $('#modalTitle').text('Add Inc And Dec');
                    $('#modal-center').modal('show');

                });

                $(document).on('click', '.deleteBonusBtn', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("supper_admin.inc-and-deces.destroy", ":id") }}'.replace(':id', id);

                    Swal.fire({
                        title: 'Delete inc and dec?',
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
                                        fetchIncAnddecs();
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function () {
                                    Swal.fire('Error!', 'Failed to delete the inc and dec.', 'error');
                                }
                            });
                        }
                    });
                });
            });
        </script>

    @endsection
@endsection
