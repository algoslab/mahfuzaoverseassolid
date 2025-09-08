@extends('backend.layouts.app')
@section('title', config('app.name') . ' - Deparmnets')

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
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
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
            <h3 class="box-title">Employee</h3>
            <h6 class="box-subtitle">This is all Employee List</h6>
        </div>
        <button type="button" class="btn btn-warning addEmpButton" data-toggle="modal" data-target="#modal-center">
            <i class="fa-solid fa-plus"></i> Add Data
        </button>
    </div>

    @include('backend.components.hrm.employee_modal')
    @include('backend.components.hrm.finger_modal')
    @include('backend.components.hrm.card_modal')
    @include('backend.components.hrm.right_qualification_modal')

    <div class="box-body">
        <div class="table-responsive">
            <table id="customDataTable" style="table-layout: fixed; width: 100%;" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                <thead>
                    <tr>
                        <th style="">Action</th>
                        <th style="">Serial</th>
                        <th style="">Code</th>
                        <th style="">Image</th>
                        <th style="">Name</th>
                        <th style="">Qualifications</th>
                        <th style="">History</th>
                        <th style="">Traning</th>
                        <th style="">Social Links</th>
                        <th style="">Documents</th>
                        <th style="">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $key =>$data)
                    <tr>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bars"></i> Action
                                </button>
                                <div class="dropdown-menu">
                                    <!-- Edit Button inside Dropdown -->
                                    <a href="#" class="dropdown-item editEmpButton" data-toggle="modal" data-target="#modal-center" data-id="{{ $data->id }}">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>

                                    <a href="#" class="dropdown-item editFingerButton" data-toggle="modal" data-target="#modal-finger" data-id="{{ $data->id }}">
                                        <i class="fa-solid fa-fingerprint"></i> Finger
                                    </a>

                                    <a href="#" class="dropdown-item editCardButton" data-toggle="modal" data-target="#modal-card" data-id="{{ $data->id }}">
                                        <i class="fa-solid fa-id-card"></i> Access Card
                                    </a>
                                    
                                    <a href="#" class="dropdown-item text-danger deleteemployeeBtn" data-id="{{ $data->id }}">
                                        <i class="fa fa-trash"></i> Delete
                                    </a>
                                    <!-- Delete Form inside Dropdown -->
                                    {{-- <button type="button"
                                            class="dropdown-item text-danger deleteemployeeBtn"
                                            data-id="{{ $data->id }}">
                                        <i class="fa fa-trash"></i> Delete
                                    </button> --}}
                                </div>
                            </div>
                        </td>
                        
                        <td>{{ $key + 1 }}</td>
                        <td class="wrap-text">{{ $data->employee_code }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $data->photo) }}" alt="Photo" width="50" height="50">
                        </td>
                        <td class="wrap-text">{{ $data->first_name . ' ' . $data->last_name }}</td>
                        
                        <td>
                            <span class="badge badge-danger" data-toggle="modal" data-target="#modal-right">Qualifications</span>
                        </td>
                        <td>
                            <span class="badge badge-danger">History</span>
                        </td>
                        <td>
                            <span class="badge badge-danger">Traning</span>
                        </td>
                        <td>
                            <span class="badge badge-danger">Socials</span>
                        </td>
                        <td>
                            <span class="badge badge-danger">Documents</span>
                        </td>
                        <td>
                            <span class="badge {{ $data->status === 1 ? 'badge-success' : 'badge-danger' }}">
                                {{ $data->status === 1 ? 'Active' : 'Inactive' }}
                            </span>
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
            function fetchemployee() {
                $.ajax({
                    url: '{{ route("admin.employees.index") }}',
                    type: 'GET',
                    success: function (data) {
                        let newBody = $(data).find('table tbody').html();
                        $('#customDataTable tbody').html(newBody);
                    },
                    error: function () {
                        console.error('Failed to refresh employee table.');
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
                fetchBranches();
                fetchDepartments();
                fetchDesignations();
                fetchRoster();
                fetchRoles();

                function updatePreview(inputSelector, targetSelector, eventType = 'input') {
                    $(document).on(eventType, inputSelector, function () {
                        let value;
                        if ($(this).is('select')) {
                            value = $(this).find('option:selected').text(); // get selected text
                        } else {
                            value = $(this).val(); // for input fields
                        }
                        $(targetSelector).text(value);
                    });
                    const el = $(inputSelector);
                    let initialValue;
                    if (el.is('select')) {
                        initialValue = el.find('option:selected').text();
                    } else {
                        initialValue = el.val();
                    }
                    $(targetSelector).text(initialValue);
                }


                function fetchBranches() {
                    $.ajax({
                        url: "{{ route('admin.branch.active') }}",
                        method: "GET",
                        success: function(data) {
                            let select = $('#branchSelect');
                            select.empty();
                            select.append('<option value="" disabled selected>Select a Branch</option>');
                            data.forEach(function(branches) {
                                select.append('<option value="' + branches.id + '">' + branches.name + '</option>');
                            });
                            updatePreview('#branchSelect', '#step3_branchSelect', 'change');
                        },
                        error: function(xhr) {
                            console.error("Failed to fetch Branch:", xhr);
                        }
                    });
                }

                function fetchDepartments() {
                    $.ajax({
                        url: "{{ route('admin.department.active') }}",
                        method: "GET",
                        success: function(data) {
                            let select = $('#departmentSelect');
                            select.empty();
                            select.append('<option value="" disabled selected>Select a Department</option>');
                            data.forEach(function(departments) {
                                select.append('<option value="' + departments.id + '">' + departments.name + '</option>');
                            });
                            updatePreview('#departmentSelect', '#step3_departmentSelect', 'change');
                        },
                        error: function(xhr) {
                            console.error("Failed to fetch Department:", xhr);
                        }
                    });
                }

                function fetchDesignations() {
                    $.ajax({
                        url: "{{ route('admin.designation.active') }}",
                        method: "GET",
                        success: function(data) {
                            let select = $('#designationSelect');
                            select.empty();
                            select.append('<option value="" disabled selected>Select a Designation</option>');
                            data.forEach(function(designations) {
                                select.append('<option value="' + designations.id + '">' + designations.name + '</option>');
                            });
                            updatePreview('#designationSelect', '#step3_designationSelect', 'change');
                        },
                        error: function(xhr) {
                            console.error("Failed to fetch Department:", xhr);
                        }
                    });
                }

                function fetchRoster() {
                    $.ajax({
                        url: "{{ route('admin.roster.active') }}",
                        method: "GET",
                        success: function(data) {
                            let select = $('#rosterSelect');
                            select.empty();
                            select.append('<option value="" disabled selected>Select a Rosters</option>');
                            data.forEach(function(rosters) {
                                select.append('<option value="' + rosters.id + '">' + rosters.name + '</option>');
                            });
                            updatePreview('#rosterSelect', '#step3_rosterSelect', 'change');
                        },
                        error: function(xhr) {
                            console.error("Failed to fetch Rosters:", xhr);
                        }
                    });
                }

                function fetchRoles() {
                    $.ajax({
                        url: "{{ route('admin.roles.active') }}",
                        method: "GET",
                        success: function(data) {
                            let select = $('#roleSelect');
                            select.empty();
                            select.append('<option value="" disabled selected>Select a Roles</option>');
                            data.forEach(function(roles) {
                                select.append('<option value="' + roles.id + '">' + roles.name + '</option>');
                            });
                            updatePreview('#roleSelect', '#step3_roleSelect', 'change');
                        },
                        error: function(xhr) {
                            console.error("Failed to fetch Roles:", xhr);
                        }
                    });
                }

                function submitEmployeeForm() {
                    let id = $('#employee_id').val()?.trim();
                    let isEdit = id && id !== '';
                    let formData = new FormData($('#employeeFrom')[0]);

                    let url = isEdit
                        ? `{{ route('admin.employees.update', ['employee' => '__id__']) }}`.replace('__id__', id)
                        : `{{ route('admin.employees.store') }}`;

                        if (isEdit) {
                            formData.append('_method', 'PUT');
                        }

                    Swal.fire({
                        title: isEdit ? "Update employee?" : "Add employee?",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonText: "Yes, proceed"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                type: 'POST',
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function (response) {
                                    console.log('Success Response:', response);
                                    if (response.status === 'success') {
                                        $('#modal-center').modal('hide');
                                        Swal.fire('Success!', response.message, 'success');
                                        $('#employeeFrom')[0].reset();
                                        $('#employee_id').val('');
                                        fetchemployee();
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function (xhr) {
                                    let message = 'Failed to save employee.';

                                    if (xhr.responseJSON?.errors) {
                                        const errors = xhr.responseJSON.errors;
                                        message = Object.values(errors).flat().join('<br>');
                                    } else if (xhr.responseJSON?.message) {
                                        message = xhr.responseJSON.message;
                                    }

                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Validation Error',
                                        html: message
                                    });
                                }
                            });
                        }
                    });
                }

                $('#employeeFrom').on('submit', function (e) {
                    e.preventDefault();
                    submitEmployeeForm(); 
                });

                function previewData(){
                    updatePreview('#first_name', '#step3_first_name');
                    updatePreview('#last_name', '#step3_last_name');
                    updatePreview('#religion', '#step3_religion', 'change');
                    updatePreview('#gender', '#step3_gender', 'change');
                    updatePreview('#marital_status', '#step3_marital_status', 'change');
                    updatePreview('#date_of_birth', '#step3_date_of_birth');
                    updatePreview('#date_of_joining', '#step3_date_of_joining');
                    updatePreview('#personal_phone', '#step3_personal_phone');
                    updatePreview('#blood_group', '#step3_blood_group', 'change');
                    updatePreview('#personal_email', '#step3_personal_email');
                    updatePreview('#contact_person_number', '#step3_contact_person_number');
                    updatePreview('#office_phone', '#step3_office_phone');
                    updatePreview('#office_email', '#step3_office_email');
                    updatePreview('#nid_number', '#step3_nid_number');
                    updatePreview('#current_address', '#step3_current_address');
                    updatePreview('#permanent_address', '#step3_permanent_address');
                    updatePreview('#note', '#step3_note');
                    updatePreview('#employee_code', '#step3_employee_code');
                    updatePreview('#basic_salary_monthly', '#step3_basic_salary_monthly');
                    updatePreview('#basic_salary_daily', '#step3_basic_salary_daily');
                    updatePreview('#mobile_allowance', '#step3_mobile_allowance');
                    updatePreview('#salary_pay_method', '#step3_salary_pay_method', 'change');
                    updatePreview('#contract_type', '#step3_contract_type', 'change');
                    updatePreview('#access_card', '#step3_access_card');
                    updatePreview('#weekend_day', '#step3_weekend_day', 'change');
                    $(document).on('change', '#photo', function (e) {
                        const file = this.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                $('#step3_photo').attr('src', e.target.result).show();
                            };
                            reader.readAsDataURL(file);
                        } else {
                            $('#step3_photo').attr('src', '').hide();
                        }
                    });
                }


                function initWizard(id = null) {
                    try {
                        $("#employeeFrom").steps("destroy"); 
                    } catch (e) {}

                    $("#employeeFrom").steps({
                        headerTag: "h6",
                        bodyTag: "section",
                        transitionEffect: "fade",
                        titleTemplate: '<span class="number">#index#</span> #title#',
                        labels: {
                            finish: id ? "Update" : "Submit",
                            next: "Next",
                            previous: "Previous"
                        },
                        onStepChanging: function (event, currentIndex, newIndex) {
                            var form = $("#employeeFrom");
                            if (newIndex < currentIndex) {
                                return true;
                            }
                            form.validate().settings.ignore = ":disabled,:hidden";
                            return form.valid();
                        },
                        onFinishing: function (event, currentIndex) {
                            var form = $("#employeeFrom");
                            form.validate().settings.ignore = ":disabled";
                            return form.valid();
                        },
                        onFinished: function (event, currentIndex) {
                            event.preventDefault(); 
                            submitEmployeeForm();  
                        }
                    });

                    $("#employeeFrom").validate({
                        errorPlacement: function (error, element) {
                            error.addClass('text-danger'); // optional for Bootstrap
                            if (element.parent('.input-group').length) {
                                error.insertAfter(element.parent()); // for input groups
                            } else {
                                error.insertAfter(element); // default placement
                            }
                        },
                        highlight: function (element) {
                            $(element).addClass('error');
                        },
                        unhighlight: function (element) {
                            $(element).removeClass('error');
                        }
                    });

                    $('#basic_salary_monthly').on('input', function () {
                        let monthlySalary = parseFloat($(this).val());

                        // Check if input is a valid number
                        if (!isNaN(monthlySalary) && monthlySalary > 0) {
                            let dailySalary = (monthlySalary / 30).toFixed(2);
                            $('#basic_salary_daily').val(dailySalary);
                            $('#step3_basic_salary_daily').text(dailySalary);
                        } else {
                            $('#basic_salary_daily').val('');
                            $('#step3_basic_salary_daily').val('');
                        }
                    });
                }

                $(document).on('click', '.addEmpButton', function () {
                    $('#employeeFrom')[0].reset();
                    $('#employee_id').val('');
                    $('#existing-picture').attr('src', '').hide();
                    $('#modalTitle').text('Add Employee');
                    $('#modal-center').modal('show');
                    initWizard();
                    previewData();
                });

                $(document).on('click', '.editEmpButton', function () {
                    const id = $(this).data('id');
                    $('#employee_id').val(id);
                    const url = '{{ route("admin.employees.edit", ":id") }}'.replace(':id', id);
                    const storageBaseUrl = "{{ asset('storage') }}/";
                    initWizard(id);
                    // Now call AJAX to fill data
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (res) {
                            // Populate form fields
                            $('#employee_id').val(res.id ?? '');
                            $('#first_name').val(res.first_name ?? '');
                            $('#last_name').val(res.last_name ?? '');
                            $('#personal_email').val(res.personal_email ?? '');
                            $('#office_email').val(res.office_email ?? '');
                            $('#personal_phone').val(res.personal_phone ?? '');
                            $('#office_phone').val(res.office_phone ?? '');
                            $('#contact_person_number').val(res.contact_person_number ?? '');
                            $('#employee_code').val(res.employee_code ?? '');
                            $('#nid_number').val(res.nid_number ?? '');
                            $('#gender').val(res.gender ?? '');
                            $('#religion').val(res.religion ?? '');
                            $('#marital_status').val(res.marital_status ?? '');
                            $('#date_of_birth').val(res.date_of_birth ?? '');
                            $('#date_of_joining').val(res.date_of_joining ?? '');
                            $('#blood_group').val(res.blood_group ?? '');
                            $('#branch_id').val(res.branch_id ?? '');
                            $('#department_id').val(res.department_id ?? '');
                            $('#designation_id').val(res.designation_id ?? '');
                            $('#role_id').val(res.role_id ?? '');
                            $('#roster_id').val(res.roster_id ?? '');
                            $('#basic_salary_monthly').val(res.basic_salary_monthly ?? '');
                            $('#basic_salary_daily').val(res.basic_salary_daily ?? '');
                            $('#mobile_allowance').val(res.mobile_allowance ?? '');
                            $('#salary_pay_method').val(res.salary_pay_method ?? '');
                            $('#contract_type').val(res.contract_type ?? '');
                            $('#access_card').val(res.access_card ?? '');
                            $('#white_list').prop('checked', res.white_list == 1);
                            $('#weekend_day').val(res.weekend_day ?? '');
                            $('#status').prop('checked', res.status == 1);
                            $('#current_address').val(res.current_address ?? '');
                            $('#permanent_address').val(res.permanent_address ?? '');
                            $('#note').val(res.note ?? '');
                            // Update existing photo and preview photo
                            if (res.photo) {
                                const photoUrl = storageBaseUrl + res.photo;
                                $('#existing-picture').attr('src', photoUrl).show();
                                $('#step3_photo').attr('src', photoUrl).show();
                            } else {
                                $('#existing-picture').hide();
                                $('#step3_photo').hide();
                            }
                            $('#branchSelect').val(res.branch_id).trigger('change');
                            $('#roleSelect').val(res.role_id).trigger('change');
                            $('#departmentSelect').val(res.department_id).trigger('change');
                            $('#designationSelect').val(res.designation_id).trigger('change');
                            $('#rosterSelect').val(res.roster_id).trigger('change');
                            $('#modalTitle').text('Edit Employee');
                            $('#modal-center').modal('show');
                            previewData();
                            
                        },
                        error: function () {
                            Swal.fire('Error', 'Could not load employee data.', 'error');
                        }
                    });
                });


                $(document).on('click', '.editFingerButton', function () {
                    $('#fingerForm')[0].reset();
                    const id = $(this).data('id'); 
                    $('#employee_id').val(id); 
                    $.ajax({
                        url: `{{ route('admin.employee.finger', ['id' => '__id__']) }}`.replace('__id__', id),
                        method: 'GET',
                        success: function (response) {
                            $('#employeeName1').text(response.full_name);
                            $('#add_finger').val(response.add_finger);
                            $('#is_active_finger').prop('checked', response.is_active_finger);
                            $('#modalTitle').text('Edit Finger');
                            // Show the modal
                            $('#modal-finger').modal('show');
                        },
                        error: function () {
                            Swal.fire('Error!', 'Failed to fetch employee data.', 'error');
                        }
                    });
                });

                $('#fingerForm').on('submit', function (e) {
                    e.preventDefault();
                    let id = $('#employee_id').val()?.trim();
                    let addFingerData = $('#add_finger').val();
                    let isActiveFinger = $('#is_active_finger').is(':checked') ? 1 : 0;

                    if (!id) {
                        Swal.fire('Error!', 'Employee ID is required.', 'error');
                        return;
                    }

                    $.ajax({
                        url: `{{ route('admin.employee.finger', ['id' => '__id__']) }}`.replace('__id__', id),
                        method: 'POST',
                        data: {
                            add_finger: addFingerData,
                            is_active_finger: isActiveFinger,
                            _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                        },
                        success: function (response) {
                            $('#modal-finger').modal('hide'); 
                            Swal.fire('Success!', response.message, 'success'); 
                        },
                        error: function (xhr) {
                            let message = 'Failed to save fingerprint data.';
                            if (xhr.responseJSON?.errors) {
                                const errors = xhr.responseJSON.errors;
                                message = Object.values(errors).flat().join('<br>'); 
                            } else if (xhr.responseJSON?.message) {
                                message = xhr.responseJSON.message; 
                            }

                            // Show error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                html: message
                            });
                        }
                    });
                });

                $(document).on('click', '.editCardButton', function () {
                    $('#accessCardForm')[0].reset();
                    $('#employee_id').val(''); 

                    const id = $(this).data('id'); 
                    $('#employee_id').val(id); 
                    $.ajax({
                        url: `{{ route('admin.employee.card', ['id' => '__id__']) }}`.replace('__id__', id),
                        method: 'GET',
                        success: function (response) {
                            $('#employeeName').text(response.full_name);
                            $('#current_cardnumber').val(response.access_card);
                            $('#modalTitle').text('Edit Access Card');
                            $('#modal-card').modal('show');
                        },
                        error: function () {
                            Swal.fire('Error!', 'Failed to fetch employee data.', 'error');
                        }
                    });
                });

                $('#accessCardForm').on('submit', function (e) {
                    e.preventDefault();
                    let id = $('#employee_id').val()?.trim();
                    let accessCardData = $('#cardnumber').val();
                    if (!id) {
                        Swal.fire('Error!', 'Employee ID is required.', 'error');
                        return;
                    }

                    $.ajax({
                        url: `{{ route('admin.employee.card', ['id' => '__id__']) }}`.replace('__id__', id),
                        method: 'POST',
                        data: {
                            access_card: accessCardData,
                            _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                        },
                        success: function (response) {
                            $('#modal-card').modal('hide'); 
                            Swal.fire('Success!', response.message, 'success'); 
                        },
                        error: function (xhr) {
                            let message = 'Failed to save Card Access data.';
                            if (xhr.responseJSON?.errors) {
                                const errors = xhr.responseJSON.errors;
                                message = Object.values(errors).flat().join('<br>'); 
                            } else if (xhr.responseJSON?.message) {
                                message = xhr.responseJSON.message; 
                            }

                            // Show error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                html: message
                            });
                        }
                    });
                });


                $(document).on('click', '.deleteemployeeBtn', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("admin.employees.destroy", ":id") }}'.replace(':id', id);

                    Swal.fire({
                        title: 'Delete employee?',
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
                                    _token: '{{ csrf_token() }}',
                                    _method: 'DELETE'
                                },
                                success: function (res) {
                                    if (res.status === 'success') {
                                        Swal.fire('Deleted!', res.message, 'success');
                                        fetchemployee();
                                    } else {
                                        Swal.fire('Error!', res.message, 'error');
                                    }
                                },
                                error: function () {
                                    Swal.fire('Error!', 'Failed to delete.', 'error');
                                }
                            });
                        }
                    });
                });
            });
        </script>
    @endsection

@endsection
