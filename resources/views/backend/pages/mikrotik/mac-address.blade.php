@extends('backend.layouts.app')
@section('title', config('app.name') . ' - Mac Address')

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
            <h3 class="box-title">Mac Address</h3>
            <h6 class="box-subtitle">This is all Mac Address List</h6>
        </div>
        <button type="button" class="btn btn-warning addMacButton" data-toggle="modal" data-target="#modal-center">
            <i class="fa-solid fa-plus"></i> Add Data
        </button>
    </div>

    @include('backend.components.mikrotik.mac_address_modal')

    <div class="box-body">
        <div class="table-responsive">
            <table id="customDataTable" style="table-layout: fixed; width: 100%;" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                <thead>
                    <tr>
                        <th style="">Action</th>
                        <th style="">Serial</th>
                        <th style="">Branch</th>
                        <th style="">Router</th>
                        <th style="">Address</th>
                        <th style="">Type</th>
                        <th style="">Status</th>
                        <th style="">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($macaddress as $key =>$service)
                    <tr>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bars"></i> Action
                                </button>
                                <div class="dropdown-menu">

                                    <!-- Delete Form inside Dropdown -->
                                    <button type="button"
                                            class="dropdown-item text-danger deleteMacButton"
                                            data-id="{{ $service->id }}">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </td>
                        
                        <td class="wrap-text">{{ $key + 1 }}</td>
                        <td class="wrap-text">{{ $service->branch->name}}</td>
                        <td class="wrap-text">{{ $service->router->host}}</td>
                        <td class="wrap-text">{{ $service->mac_address ?? $service->ip_address }}</td>
                        <td class="wrap-text">{{ $service->type }}</td>
                        <td>
                            <span class="badge {{ $service->status == 1 ? 'badge-success' : 'badge-danger' }}">
                                {{ $service->status == 1 ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="wrap-text">{{ $service->created_at->format('F d, Y') }}</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div>
</div>

    @section('script')
        <script>
            function fetchmacaddress() {
                $.ajax({
                    url: '{{ route("admin.mac-address.index") }}',
                    type: 'GET',
                    success: function (data) {
                        let newBody = $(data).find('table tbody').html();
                        $('#customDataTable tbody').html(newBody);
                    },
                    error: function () {
                        console.error('Failed to refresh hotspot table.');
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

            fetchBranch();
            $('#branchSelect').on('change', function () {
                const selectedBranchId = $(this).val();
                fetchRouters(selectedBranchId);
            })

            $(document).ready(function () {

                 $('input[name="address_type"]').change(function () {
                    if ($(this).val() === 'mac') {
                        $('#mac_address_group').removeClass('d-none');
                        $('#ip_address_group').addClass('d-none');
                    } else {
                        $('#ip_address_group').removeClass('d-none');
                        $('#mac_address_group').addClass('d-none');
                    }
                });

                $('#macForm').on('submit', function (e) {
                    e.preventDefault();

                    let isEdit = $('#mac_address_id').val() !== ''; 
                    let formData = new FormData(this); 
                    let id = $('#mac_address_id').val(); 
                    let url = isEdit 
                        ? `{{ route('admin.mac-address.update', ['mac_address' => '__id__']) }}`.replace('__id__', id) 
                        : `{{ route('admin.mac-address.store') }}`;

                    let method = isEdit ? 'POST' : 'POST'; 
                    if (isEdit) {
                        formData.append('_method', 'PUT');
                    }

                    Swal.fire({
                        title: isEdit ? "Update MAC Address?" : "Add MAC Address?",
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
                                        $('#macForm')[0].reset();
                                        $('#mac_address_id').val('');
                                        fetchmacaddress();
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function () {
                                    Swal.fire('Error!', 'Failed to save hotspot.', 'error');
                                }
                            });
                        }
                    });
                });

                $(document).on('click', '.addMacButton', function () {
                    $('#macForm')[0].reset();
                    $('#mac_address_id').val('');
                    $('#modalTitle').text('Add Mac Address');
                    $('#modal-center').modal('show');
                });


                $(document).on('click', '.deleteMacButton', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("admin.mac-address.destroy", ":id") }}'.replace(':id', id);

                    Swal.fire({
                        title: 'Delete hotspot?',
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
                                        fetchmacaddress();
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
