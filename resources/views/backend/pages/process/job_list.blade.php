@extends('backend.layouts.app')
@section('title', config('app.name') . ' - Job List')

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
            <h3 class="box-title">Job Lists</h3>
            <h6 class="box-subtitle">This is all Job List List</h6>
        </div>
        <button type="button" class="btn btn-warning addjobListsButton" data-toggle="modal" data-target="#modal-center">
            <i class="fa-solid fa-plus"></i> Add Data
        </button>
    </div>

    @include('backend.components.process.job_list_modal')

    <div class="box-body">
        <div class="table-responsive">
            <table id="customDataTable" style="table-layout: fixed; width: 100%;" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                <thead>
                    <tr>
                        <th style="">Action</th>
                        <th style="">Serial</th>
                        <th style="">Category</th>
                        <th style="">Job Name</th>
                        <th style="">Job type </th>
                        <th style="">Note</th>
                        <th style="">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($JobLists as $key =>$serivice)
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
                                    
                                    <button type="button"
                                            class="dropdown-item text-danger deletejobListsBtn"
                                            data-id="{{ $serivice->id }}">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </td>
                        
                        <td>{{ $key + 1 }}</td>
                        <td class="wrap-text">{{ $serivice->jobCategory->name }}</td>
                        <td class="wrap-text">{{ $serivice->name  }}</td>
                        <td>
                            <span class="{{ $serivice->job_type === 'paid' ? 'text-success' : 'text-warning' }}">
                                {{ $serivice->job_type === 'paid' ? 'Paid' : 'Comission' }}
                            </span>
                        </td>
                        <td class="wrap-text">{{ $serivice->note ?? ''}}</td>
                        <td>
                            <span class="badge {{ $serivice->status == 1 ? 'badge-success' : 'badge-danger' }}">
                                {{ $serivice->status == 1 ? 'Active' : 'Inactive' }}
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
            function fetchjobLists() {
                $.ajax({
                    url: '{{ route("admin.jobLists.index") }}',
                    type: 'GET',
                    success: function (data) {
                        let newBody = $(data).find('table tbody').html();
                        $('#customDataTable tbody').html(newBody);
                    },
                    error: function () {
                        console.error('Failed to refresh Job List table.');
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

            fetchJobCategory();

            $(document).ready(function () {
                $('#jobListForm').on('submit', function (e) {
                    e.preventDefault();
                    let isEdit = $('#job_list_id').val() !== '';
                    let formData = new FormData(this);
                    let id = $('#job_list_id').val();

                    let url = isEdit
                        ? `{{ route('admin.jobLists.update', ['jobList' => '__id__']) }}`.replace('__id__', id)
                        : `{{ route('admin.jobLists.store') }}`;

                    if (isEdit) {
                        formData.append('_method', 'PUT');
                    }

                    Swal.fire({
                        title: isEdit ? "Update Job List?" : "Add Job List?",
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
                                        $('#jobListForm')[0].reset();
                                        $('#job_list_id').val('');
                                        fetchjobLists();
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



                $(document).on('click', '.addjobListsButton', function () {
                    $('#jobListForm')[0].reset();
                    $('#job_list_id').val('');
                    $('#jobCategorySelect').val('').trigger('change');
                    $('#job_type').val(res.job_type).trigger('change');
                    $('#modalTitle').text('Add Job List');
                    $('#modal-center').modal('show');
                });

                $(document).on('click', '.editBlogButton', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("admin.jobLists.edit", ":id") }}'.replace(':id', id);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (res) {
                            $('#job_list_id').val(id);
                            $('#name').val(res.name);
                            $('#job_type').val(res.job_type).trigger('change');
                            $('#note').val(res.note);
                            $('#status').prop('checked', res.status == 1);
                            $('#modalTitle').text('Edit Job List');
                            $('#modal-center').modal('show');
                            $('#jobCategorySelect').val(res.job_category_id).trigger('change');
                        },
                        error: function () {
                            Swal.fire('Error', 'Could not load Job List data.', 'error');
                        }
                    });
                });


                $(document).on('click', '.deletejobListsBtn', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("admin.jobLists.destroy", ":id") }}'.replace(':id', id);

                    Swal.fire({
                        title: 'Delete Job List?',
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
                                        fetchjobLists();
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
