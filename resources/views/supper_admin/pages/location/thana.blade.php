@extends('supper_admin.layouts.app')
@section('title', config('app.name') . ' - Thana')

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
            <h3 class="box-title">Thana</h3>
            <h6 class="box-subtitle">This is all Thana List</h6>
        </div>
        <button type="button" class="btn btn-warning addBlogButton" data-toggle="modal" data-target="#modal-center">
            <i class="fa-solid fa-plus"></i> Add Data
        </button>
    </div>

    @include('supper_admin.components.location.thana_modal')

    <div class="box-body">
        <div class="table-responsive">
            <table id="customDataTable" style="table-layout: fixed; width: 100%;" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                <thead>
                    <tr>
                        <th style="">Action</th>
                        <th style="">Serial</th>
                        <th style="">Name</th>
                        <th style="">District</th>
                        <th style="">Code</th>
                        <th style="">Status</th>
                        <th style="">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($thanas as $key =>$serivice)
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
                                            class="dropdown-item text-danger deletethanaBtn"
                                            data-id="{{ $serivice->id }}">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </td>
                        
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $serivice->name}}</td>
                        <td class="wrap-text">{{ $serivice->district->name  }}</td>
                        <td class="wrap-text">{{ $serivice->code  }}</td>
                        <td>
                            <span class="badge {{ $serivice->status == 'Active' ? 'badge-success' : 'badge-danger' }}">
                                {{ $serivice->status == 'Active' ? 'Active' : 'Inactive' }}
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
            function fetchthanas() {
                $.ajax({
                    url: '{{ route("supper_admin.thanas.index") }}',
                    type: 'GET',
                    success: function (data) {
                        let newBody = $(data).find('table tbody').html();
                        $('#customDataTable tbody').html(newBody);
                    },
                    error: function () {
                        console.error('Failed to refresh country table.');
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
                fetchDistrict();
                function fetchDistrict() {
                    $.ajax({
                        url: "{{ route('supper_admin.district.active') }}",
                        method: "GET",
                        success: function(data) {
                            let select = $('#districtSelect');
                            select.empty();
                            select.append('<option value="" disabled selected>Select a district</option>');
                            data.forEach(function(district) {
                                select.append('<option value="' + district.id + '">' + district.name + '</option>');
                            });
                        },
                        error: function(xhr) {
                            console.error("Failed to fetch countriess:", xhr);
                        }
                    });
                }

                $('#thanaFrom').on('submit', function (e) {
                    e.preventDefault();

                    let isEdit = $('#thana_id').val() !== ''; 
                    let formData = new FormData(this); 
                    let id = $('#thana_id').val(); 
                    let url = isEdit 
                        ? `{{ route('supper_admin.thanas.update', ['thana' => '__id__']) }}`.replace('__id__', id) 
                        : `{{ route('supper_admin.thanas.store') }}`;

                    let method = isEdit ? 'POST' : 'POST'; 
                    if (isEdit) {
                        formData.append('_method', 'PUT');
                    }

                    Swal.fire({
                        title: isEdit ? "Update Thana?" : "Add Thana?",
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
                                        $('#thanaFrom')[0].reset();
                                        $('#thana_id').val('');
                                        fetchthanas();
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function () {
                                    Swal.fire('Error!', 'Failed to save country.', 'error');
                                }
                            });
                        }
                    });
                });

                $(document).on('click', '.addBlogButton', function () {
                    $('#thanaFrom')[0].reset();
                    $('#thana_id').val('');
                    $('#modalTitle').text('Add Thana');
                    $('#modal-center').modal('show');
                });

                $(document).on('click', '.editBlogButton', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("supper_admin.thanas.edit", ":id") }}'.replace(':id', id);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (res) {
                            $('#thana_id').val(id);
                            $('#name').val(res.name);
                            $('#code').val(res.code);
                            $('#status').prop('checked', res.status === 'Active');
                            $('#modalTitle').text('Edit Thana');
                            $('#modal-center').modal('show');
                            $('#districtSelect').val(res.district_id).trigger('change');
                        },
                        error: function () {
                            Swal.fire('Error', 'Could not load Thana data.', 'error');
                        }
                    });
                });

                $(document).on('click', '.deletethanaBtn', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("supper_admin.thanas.destroy", ":id") }}'.replace(':id', id);

                    Swal.fire({
                        title: 'Delete Thana?',
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
                                        fetchthanas();
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
