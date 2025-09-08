@extends('backend.layouts.app')
@section('title', config('app.name') . ' - Branch')

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
            <h3 class="box-title">Branch</h3>
            <h6 class="box-subtitle">This is all branches List</h6>
        </div>
        <button type="button" class="btn btn-warning addBlogButton" data-toggle="modal" data-target="#modal-center">
            <i class="fa-solid fa-plus"></i> Add Data
        </button>
    </div>

    @include('backend.components.myOffice.branch_modal')

    <div class="box-body">
        <div class="table-responsive">
            <table id="customDataTable" style="table-layout: fixed; width: 100%;" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                <thead>
                    <tr>
                        <th style="">Action</th>
                        <th style="">Serial</th>
                        <th style="">Name</th>
                        <th style="">Code</th>
                        <th style="">Phone</th>
                        <th style="">Picture</th>
                        <th style="">Status</th>
                        <th style="">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($branches as $key =>$serivice)
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
                                            class="dropdown-item text-danger deleteBranchBtn"
                                            data-id="{{ $serivice->id }}">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </td>
                        
                        <td>{{ $key + 1 }}</td>
                        <td class="wrap-text">{{ $serivice->name  }}</td>
                        <td>{{ $serivice->code}}</td>
                        <td class="wrap-text">{{ $serivice->phone ?? "N/A"  }}</td>

                        <td>
                            @if($serivice->picture)
                                <img src="{{ asset('storage/' . $serivice->picture) }}" alt="Branch Picture" width="50">
                            @else
                                N/A
                            @endif
                            
                        </td>
                        <td>
                            <span class="badge {{ $serivice->status === 1 ? 'badge-success' : 'badge-danger' }}">
                                {{ $serivice->status === 1 ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="wrap-text">{{ $serivice->created_at->format('F d, Y') }}</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div>
</div>

    @section('script')
        <script>
            function fetchBranch() {
                $.ajax({
                    url: '{{ route("admin.branches.index") }}',
                    type: 'GET',
                    success: function (data) {
                        let newBody = $(data).find('table tbody').html();
                        $('#customDataTable tbody').html(newBody);
                    },
                    error: function () {
                        console.error('Failed to refresh Branch table.');
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
                $('#branchFrom').on('submit', function (e) {
                    e.preventDefault();
                    let isEdit = $('#branch_id').val() !== '';
                    let formData = new FormData(this);
                    let id = $('#branch_id').val();

                    let url = isEdit
                        ? `{{ route('admin.branches.update', ['branch' => '__id__']) }}`.replace('__id__', id)
                        : `{{ route('admin.branches.store') }}`;

                    if (isEdit) {
                        formData.append('_method', 'PUT');
                    }

                    Swal.fire({
                        title: isEdit ? "Update Branch?" : "Add Branch?",
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
                                        $('#branchFrom')[0].reset();
                                        $('#branch_id').val('');
                                        fetchBranch();
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


                $(document).on('click', '.addBlogButton', function () {
                    $('#branchFrom')[0].reset();
                    $('#branch_id').val('');
                    $('#existing-picture').attr('src', '').hide();
                    $('#modalTitle').text('Add Branch');
                    $('#modal-center').modal('show');

                });

                $(document).on('click', '.editBlogButton', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("admin.branches.edit", ":id") }}'.replace(':id', id);
                    const storageBaseUrl = "{{ asset('storage') }}/";
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (res) {
                            console.log(res);
                            $('#branch_id').val(id);
                            $('#name').val(res.name);
                            $('#code').val(res.code);
                            $('#phone').val(res.phone);
                            $('#email').val(res.email);
                            if (res.picture) {
                                $('#existing-picture')
                                    .attr('src', storageBaseUrl + res.picture)
                                    .show();
                            } else {
                                $('#existing-picture').hide();
                            }
                            $('#address').val(res.address);
                            $('#note').val(res.note);
                            $('#status').prop('checked', res.status === 1);
                            $('#modalTitle').text('Edit Branch');
                            $('#modal-center').modal('show');
                            $('#countriesSelect').val(res.branch_id).trigger('change');
                        },
                        error: function () {
                            Swal.fire('Error', 'Could not load Branch data.', 'error');
                        }
                    });
                });

                $(document).on('click', '.deleteBranchBtn', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("admin.branches.destroy", ":id") }}'.replace(':id', id);

                    Swal.fire({
                        title: 'Delete Branch?',
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
                                        fetchBranch();
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
