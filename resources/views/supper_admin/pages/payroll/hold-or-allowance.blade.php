@extends('supper_admin.layouts.app')
@section('title', config('app.name') . ' - Hold/Allowance')

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
                <h3 class="box-title">Hold/Allowance</h3>
                <h6 class="box-subtitle">This is all hold/allowance List</h6>
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
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
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
                        <th style="width: 5%;">DB:ID</th>
                        <th>Employee Name & ID</th>
                        <th>Department</th>
{{--                        <th>Hold Salary</th>--}}
                        <th>Mobile Bill</th>
{{--                        <th>Accommodation</th>--}}
                        <th>White List</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($employees as $key =>$employee)
                        <tr>
                            <td style="width: 5%;">{{ $key + 1 }}</td>
                            <td><b>{{$employee->employee_code}}</b> - {{$employee->first_name}} {{$employee->last_name}}</td>
                            <td><b>{{$employee->department ? $employee->department->name : '' }}</b> - {{$employee->designation ? $employee->designation->name : '' }}</td>
{{--                            <td>--}}
{{--                                <div class="form-check">--}}
{{--                                    <input class="form-check-input"--}}
{{--                                           onclick="hold_and_allowance_config('{{ $employee->id }}')"--}}
{{--                                           id="is_hold_salary_{{ $employee->id }}"--}}
{{--                                           name="is_hold_salary"--}}
{{--                                           {{ $employee->is_hold_salary == '1' ? 'checked' : '' }}--}}
{{--                                           type="checkbox">--}}
{{--                                    <label for="is_hold_salary_{{ $employee->id }}"></label>--}}
{{--                                </div>--}}
{{--                            </td>--}}
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           onclick="hold_and_allowance_config('{{ $employee->id }}')"
                                           id="is_mobile_bill_{{ $employee->id }}"
                                           name="is_mobile_bill"
                                           {{ $employee->is_mobile_bill == '1' ? 'checked' : '' }}
                                           type="checkbox">
                                    <label for="is_mobile_bill_{{ $employee->id }}"></label>
                                </div>
                            </td>
{{--                            <td>--}}
{{--                                <div class="form-check">--}}
{{--                                    <input class="form-check-input"--}}
{{--                                           onclick="hold_and_allowance_config('{{ $employee->id }}')"--}}
{{--                                           id="is_accommodation_{{ $employee->id }}"--}}
{{--                                           name="is_accommodation"--}}
{{--                                           {{ $employee->is_accommodation == '1' ? 'checked' : '' }}--}}
{{--                                           type="checkbox">--}}
{{--                                    <label for="is_accommodation_{{ $employee->id }}"></label>--}}
{{--                                </div>--}}
{{--                            </td>--}}
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           onclick="hold_and_allowance_config('{{ $employee->id }}')"
                                           id="white_list_{{ $employee->id }}"
                                           name="white_list"
                                           {{ $employee->white_list == '1' ? 'checked' : '' }}
                                           type="checkbox">
                                    <label for="white_list_{{ $employee->id }}"></label>
                                </div>
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
            function fetchHoldOrAllowance(departmentId = null) {
                $.ajax({
                    url: '{{ route("supper_admin.hold-or-allowances.index") }}',
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

            function hold_and_allowance_config(employeeId) {
                const is_hold_salary = $(`#is_hold_salary_${employeeId}`).is(':checked') ? '1' : '0';
                const is_mobile_bill = $(`#is_mobile_bill_${employeeId}`).is(':checked') ? '1' : '0';
                const is_accommodation = $(`#is_accommodation_${employeeId}`).is(':checked') ? '1' : '0';
                const white_list = $(`#white_list_${employeeId}`).is(':checked') ? '1' : '0';

                $.ajax({
                    url: `/supper_admin/hold-or-allowances/${employeeId}`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        is_hold_salary,
                        is_mobile_bill,
                        is_accommodation,
                        white_list
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            Swal.fire('Success!', response.message, 'success');
                            // Get currently selected department ID
                            const selectedDeptId = $('#departmentSelect').val();

                            // Refresh the employee list filtered by selected department
                            if (selectedDeptId) {
                                fetchHoldOrAllowance(selectedDeptId);
                            } else {
                                // If no department selected, you can reload all employees or handle accordingly
                                fetchHoldOrAllowance();
                            }
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error!', 'Failed to update allowance info.', 'error');
                    }
                });
            }

            $(document).ready(function () {

                // Trigger the fetchEmployees function when a category is selected
                $('#departmentSelect').on('change', function () {
                    const departmentId = $(this).val();
                    if (departmentId) {
                        fetchHoldOrAllowance(departmentId);  // Fetch employee based on the selected department
                    } else {
                        $('#employeeSelect').empty().append('<option value="" disabled selected>Choose Employee</option>');
                    }
                });
            });
        </script>

    @endsection
@endsection
