@extends('backend.layouts.app')
@section('title', config('app.name') . ' - Asign Job to Office')

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
            <h3 class="box-title">Asign Job to Office </h3>
            <h6 class="box-subtitle">This is all Asign Job to Office List</h6>
        </div>
        <button type="button" class="btn btn-warning addAsignButton" data-toggle="modal" data-target="#modal-center">
            <i class="fa-solid fa-plus"></i> Add Data
        </button>
    </div>

    @include('backend.components.process.asign_to_job_modal')

    <div class="box-body">
        <div class="table-responsive">
            <table id="customDataTable" style="table-layout: fixed; width: 100%;" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                <thead>
                    <tr>
                        <th style="">Action</th>
                        <th style="">Serial</th>
                        <th style="">Process Office</th>
                        <th style="">Job Name Office</th>
                        <th style="">Job Type</th>
                        <th style="">P.Cost</th>
                        <th style="">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($AsignJobToOffices as $key =>$service)
                    <tr>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bars"></i> Action
                                </button>
                                <div class="dropdown-menu">
                                    <a href="#" class="dropdown-item editBlogButton" data-toggle="modal" data-target="#modal-center" data-id="{{ $service->id }}">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    
                                    <button type="button"
                                            class="dropdown-item text-danger deleteAsignBtn"
                                            data-id="{{ $service->id }}">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </td>
                        
                        <td>{{ $key + 1 }}</td>
                        <td class="wrap-text">{{ $service->processOffice->name  }}</td>
                        <td class="wrap-text">{{ $service->jobList->name  }}</td>
                        <td class="wrap-text">{{ $service->jobList->job_type  }}</td>
                        <td class="wrap-text">{{ $service->processing_cost  }}</td>
                        <td>
                            <span class="badge {{ $service->status == 1 ? 'badge-success' : 'badge-danger' }}">
                                {{ $service->status == 1 ? 'Active' : 'Inactive' }}
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
            function fetchCandidateType() {
                $.ajax({
                    url: '{{ route("admin.asignjobtoOffice.index") }}',
                    type: 'GET',
                    success: function (data) {
                        let newBody = $(data).find('table tbody').html();
                        $('#customDataTable tbody').html(newBody);
                    },
                    error: function () {
                        console.error('Failed to refresh Process Category table.');
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
            fetchProcessCategory();
            fetchprocessOffice();
            $('#processCategorySelect').on('change', function () {
                const selectedProcessCategoryId = $(this).val();
                fetchJobCategoryData(selectedProcessCategoryId);
            })

            $('#jobCategorySelect').on('change', function () {
                const selectedPJobCategoryId = $(this).val();
                fetchJobList(selectedPJobCategoryId);
            })


            $(document).ready(function () {
                $('#asignJobOfficeForm').on('submit', function (e) {
                    e.preventDefault();
                    let isEdit = $('#asign_job_office_id').val() !== '';
                    let formData = new FormData(this);
                    let id = $('#asign_job_office_id').val();

                    let url = isEdit
                        ? `{{ route('admin.asignjobtoOffice.update', ['asignjobtoOffice' => '__id__']) }}`.replace('__id__', id)
                        : `{{ route('admin.asignjobtoOffice.store') }}`;

                    if (isEdit) {
                        formData.append('_method', 'PUT');
                    }

                    Swal.fire({
                        title: isEdit ? "Update Asign Job To Office?" : "Add Asign Job To Office?",
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
                                        $('#asignJobOfficeForm')[0].reset();
                                        $('#asign_job_office_id').val('');
                                        fetchCandidateType();
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



                $(document).on('click', '.addAsignButton', function () {
                    $('#asignJobOfficeForm')[0].reset();
                    $('#asign_job_office_id').val('');
                    $('#modalTitle').text('Add Process Category');
                    $('#modal-center').modal('show');
                });

                $(document).on('click', '.editBlogButton', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("admin.asignjobtoOffice.edit", ":id") }}'.replace(':id', id);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (res) {
                            console.log(res);
                            $('#asign_job_office_id').val(id);
                            $('#processing_cost').val(res.processing_cost);
                            $('#note').val(res.note);
                            $('#status').prop('checked', res.status == 1);
                            $('#modalTitle').text('Edit Process Category');
                            $('#modal-center').modal('show');
                            $('#processOfficeSelect').val(res.proces_office_id).trigger('change');

                            $('#processCategorySelect').val(res.process_category_id).trigger('change');
                            $('#jobCategorySelect').val(res.job_category_id).trigger('change');
                            $('#jobListSelect').val(res.job_list_id).trigger('change');

                        },
                        error: function () {
                            Swal.fire('Error', 'Could not load Process Category data.', 'error');
                        }
                    });
                });


                $(document).on('click', '.deleteAsignBtn', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("admin.processCategory.destroy", ":id") }}'.replace(':id', id);

                    Swal.fire({
                        title: 'Delete Process Category?',
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
                                        fetchCandidateType();
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
