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
            <h3 class="box-title">Department</h3>
            <h6 class="box-subtitle">This is all Department List</h6>
        </div>
        <button type="button" class="btn btn-warning addBlogButton" data-toggle="modal" data-target="#modal-center">
            <i class="fa-solid fa-plus"></i> Add Data
        </button>
    </div>

    @include('backend.components.myOffice.department_modal')

    <div class="box-body">
        <div class="table-responsive">
            <table id="customDataTable" style="table-layout: fixed; width: 100%;" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                <thead>
                    <tr>
                        <th style="">Action</th>
                        <th style="">Serial</th>
                        <th style="">Department Name</th>
                        <th style="">Department Code</th>
                        <th style="">Attendance Bonus</th>
                        <th style="">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($departments as $key =>$serivice)
                    <tr>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bars"></i> Action
                                </button>
                                <div class="dropdown-menu">
                                    <!-- Edit Button inside Dropdown -->
                                    <a href="#" class="dropdown-item editBlogButton" data-toggle="modal" data-target="#modal-center" data-id="{{ $serivice->id }}">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    
                                    <!-- Delete Form inside Dropdown -->
                                    <button type="button"
                                            class="dropdown-item text-danger deleteDepartmentBtn"
                                            data-id="{{ $serivice->id }}">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </td>
                        
                        <td>{{ $key + 1 }}</td>
                        <td class="wrap-text">{{ $serivice->name  }}</td>
                        <td>{{ $serivice->code}}</td>
                        <td class="wrap-text">
                            @if ($serivice->include_status == 1)
                                <span style="color: green;">
                                    {{ $serivice->bonous_type ?? '' }} - {{ $serivice->bonous_amount ?? '' }}
                                </span>
                            @else
                                <span style="color: red;">No</span>
                            @endif
                        </td>
                        
                        <td>
                            <span class="badge {{ $serivice->status === 1 ? 'badge-success' : 'badge-danger' }}">
                                {{ $serivice->status === 1 ? 'Active' : 'Inactive' }}
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
            function fetchDepartment() {
                $.ajax({
                    url: '{{ route("admin.departments.index") }}',
                    type: 'GET',
                    success: function (data) {
                        let newBody = $(data).find('table tbody').html();
                        $('#customDataTable tbody').html(newBody);
                    },
                    error: function () {
                        console.error('Failed to refresh Department table.');
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
                $('#departmentFrom').on('submit', function (e) {
                    e.preventDefault();

                    let isEdit = $('#department_id').val() !== '';
                    let formData = new FormData(this);
                    let id = $('#department_id').val();

                    let url = isEdit
                        ? `{{ route('admin.departments.update', ['department' => '__id__']) }}`.replace('__id__', id)
                        : `{{ route('admin.departments.store') }}`;

                    if (isEdit) {
                        formData.append('_method', 'PUT');
                    }

                    Swal.fire({
                        title: isEdit ? "Update Department?" : "Add Department?",
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
                                    if (response.status === 'success') {
                                        $('#modal-center').modal('hide');
                                        Swal.fire('Success!', response.message, 'success');
                                        $('#departmentFrom')[0].reset();
                                        $('#department_id').val('');
                                        fetchDepartment();
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function (xhr) {
                                    let message = 'Failed to save Department.';

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
                });


                $(document).ready(function () {
                    $('#include_status').on('change', function () {
                        if ($(this).is(':checked')) {
                            $('.bonus-fields').slideDown();
                            $('#bonous_type').attr('required', true);
                            $('#bonous_amount').attr('required', true);
                        } else {
                            $('.bonus-fields').slideUp();
                            $('#bonous_type').removeAttr('required').val('');
                            $('#bonous_amount').removeAttr('required').val('');
                        }
                    });
                });

                $(document).on('click', '.addBlogButton', function () {
                    $('#departmentFrom')[0].reset();
                    $('#department_id').val('');
                    $('#existing-picture').attr('src', '').hide();
                    $('#modalTitle').text('Add Department');
                    $('#modal-center').modal('show');
                    if ($('#include_status').is(':checked')) {
                        $('.bonus-fields').slideDown();
                        $('#bonous_type').attr('required', true);
                        $('#bonous_amount').attr('required', true);
                    } else {
                        $('.bonus-fields').slideUp();
                        $('#bonous_type').removeAttr('required');
                        $('#bonous_amount').removeAttr('required');
                    }
                });

                $(document).on('click', '.editBlogButton', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("admin.departments.edit", ":id") }}'.replace(':id', id);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (res) {
                            console.log(res);
                            $('#department_id').val(id);
                            $('#name').val(res.name);
                            $('#code').val(res.code);
                            $('#bonous_type').val(res.bonous_type);
                            $('#bonous_amount').val(res.bonous_amount);
                            $('#include_status').prop('checked', res.include_status == 1);
                            $('#note').val(res.note);
                            $('#status').prop('checked', res.status == 1);
                            $('#modalTitle').text('Edit Department');
                            $('#modal-center').modal('show');
                            $('#countriesSelect').val(res.department_id).trigger('change');

                            // Toggle bonus fields based on checkbox value
                            if (res.include_status == 1) {
                                $('.bonus-fields').slideDown();
                                $('#bonous_type').attr('required', true);
                                $('#bonous_amount').attr('required', true);
                            } else {
                                $('.bonus-fields').slideUp();
                                $('#bonous_type').removeAttr('required');
                                $('#bonous_amount').removeAttr('required');
                            }
                        },
                        error: function () {
                            Swal.fire('Error', 'Could not load Department data.', 'error');
                        }
                    });
                });


                $(document).on('click', '.deleteDepartmentBtn', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("admin.departments.destroy", ":id") }}'.replace(':id', id);

                    Swal.fire({
                        title: 'Delete Department?',
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
                                        fetchDepartment();
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
