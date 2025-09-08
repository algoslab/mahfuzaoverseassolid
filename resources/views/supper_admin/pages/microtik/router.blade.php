@extends('supper_admin.layouts.app')
@section('title', config('app.name') . ' - Router')

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
            <h3 class="box-title">Router</h3>
            <h6 class="box-subtitle">This is all router List</h6>
        </div>
        <button type="button" class="btn btn-warning addBlogButton" data-toggle="modal" data-target="#modal-center">
            <i class="fa-solid fa-plus"></i> Add Data
        </button>
    </div>

    @include('supper_admin.components.microtik.router_modal')

    <div class="box-body">
        <div class="table-responsive">
            <table id="customDataTable" style="table-layout: fixed; width: 100%;" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                <thead>
                    <tr>
                        <th style="">Action</th>
                        <th style="">Serial</th>
                        <th style="">Company</th>
                        <th style="">Branch</th>
                        <th style="">Host</th>
                        <th style="">Ip</th>
                        <th style="">User</th>
                        <th style="">Password</th>
                        <th style="">Status</th>
                        <th style="">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($routers as $key =>$service)
                    <tr>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bars"></i> Action
                                </button>
                                <div class="dropdown-menu">
                                    @if ($service->status == 1)
                                        <a href="#" class="dropdown-item connectButton" data-id="{{ $service->id }}">
                                            <i class="fa fa-share"></i> Connect
                                        </a>
                                    @else
                                        <a href="#" class="dropdown-item disconnectButton" data-id="{{ $service->id }}">
                                            <i class="fa fa-share"></i> Disconnect
                                        </a>
                                    @endif

                                    <a href="#" class="dropdown-item text-danger deleteRouterBtn" data-id="{{ $service->id }}">
                                        <i class="fa fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </td>
                        
                        <td>{{ $key + 1 }}</td>
                        <td class="wrap-text">{{ $service->company->company_name}}</td>
                        <td class="wrap-text">{{ $service->branch->name}}</td>
                        <td class="wrap-text">{{ $service->host}}</td>
                        <td class="wrap-text">{{ $service->host}}</td>
                        <td class="wrap-text">{{ $service->user  }}</td>
                        <td class="wrap-text">{{$service->password }}</td>
                        <td>
                            <span class="badge {{ $service->status == 1 ? 'badge-danger' : 'badge-success' }}">
                                {{ $service->status == 1 ? 'Disconnected' : 'Connected' }}
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
            function fetchrouters() {
                $.ajax({
                    url: '{{ route("supper_admin.mikrotik-devices.index") }}',
                    type: 'GET',
                    success: function (data) {
                        let newBody = $(data).find('table tbody').html();
                        $('#customDataTable tbody').html(newBody);
                    },
                    error: function () {
                        console.error('Failed to refresh Router table.');
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

            fetchCompanyData();
            $('#companySelect').on('change', function () {
                const selectedCompanyId = $(this).val();
                fetchBranchData(selectedCompanyId);
            })


            $(document).ready(function () {


                $('#routerFrom').on('submit', function (e) {
                    e.preventDefault();

                    let isEdit = $('#mikrotik_device_id').val() !== ''; 
                    let formData = new FormData(this); 
                    let id = $('#mikrotik_device_id').val(); 
                    let url = isEdit 
                        ? `{{ route('supper_admin.mikrotik-devices.update', ['mikrotik_device' => '__id__']) }}`.replace('__id__', id) 
                        : `{{ route('supper_admin.mikrotik-devices.store') }}`;

                    let method = isEdit ? 'POST' : 'POST'; 
                    if (isEdit) {
                        formData.append('_method', 'PUT');
                    }

                    Swal.fire({
                        title: isEdit ? "Update Router?" : "Add Router?",
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
                                        $('#routerFrom')[0].reset();
                                        $('#mikrotik_device_id').val('');
                                        fetchrouters();
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function () {
                                    Swal.fire('Error!', 'Failed to save Router.', 'error');
                                }
                            });
                        }
                    });
                });

                $(document).on('click', '.addBlogButton', function () {
                    $('#routerFrom')[0].reset();
                    $('#mikrotik_device_id').val('');
                    $('#modalTitle').text('Add router');
                    $('#modal-center').modal('show');
                });

                $(document).on('click', '.editBlogButton', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("supper_admin.mikrotik-devices.edit", ":id") }}'.replace(':id', id);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (res) {
                            $('#mikrotik_device_id').val(id);
                            $('#host').val(res.host);
                            $('#user').val(res.user);
                            $('#password').val(res.password);
                            $('#status').prop('checked', res.status === 1);
                            $('#modalTitle').text('Edit Router');
                            $('#modal-center').modal('show');
                        },
                        error: function () {
                            Swal.fire('Error', 'Could not load Router data.', 'error');
                        }
                    });
                });

                $(document).on('click', '.deleteRouterBtn', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("supper_admin.mikrotik-devices.destroy", ":id") }}'.replace(':id', id);

                    Swal.fire({
                        title: 'Delete Router?',
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
                                        fetchrouters();
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

                $(document).on('click', '.connectButton', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("supper_admin.mikrotik.connect", ":id") }}'.replace(':id', id);

                    Swal.fire({
                        title: 'Connect to Router?',
                        text: "Do you want to connect to this MikroTik router?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Connect',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                type: 'GET', // or 'POST' if your route expects POST
                                success: function (res) {
                                    if (res.status === 'success') {
                                        Swal.fire('Connected!', 'Router connection successful.', 'success');
                                        fetchrouters(); // optional, refresh list
                                    } else {
                                        Swal.fire('Failed!', res.message || 'Unable to connect.', 'error');
                                    }
                                },
                                error: function (xhr) {
                                    Swal.fire('Error!', 'Connection error occurred.', 'error');
                                    console.error(xhr.responseText);
                                }
                            });
                        }
                    });
                });

                $(document).on('click', '.disconnectButton', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("supper_admin.mikrotik.disconnect", ":id") }}'.replace(':id', id);

                    Swal.fire({
                        title: 'Disconnect to Router?',
                        text: "Do you want to Disconnect to this MikroTik router?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Disconnect',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                type: 'GET', // or 'POST' if your route expects POST
                                success: function (res) {
                                    if (res.status === 'success') {
                                        Swal.fire('Disconnect!', 'Router Disconnection successful.', 'success');
                                        fetchrouters();
                                    } else {
                                        Swal.fire('Failed!', res.message || 'Unable to Disconnect.', 'error');
                                    }
                                },
                                error: function (xhr) {
                                    Swal.fire('Error!', 'Connection error occurred.', 'error');
                                    console.error(xhr.responseText);
                                }
                            });
                        }
                    });
                });


            });
        </script>

    @endsection
@endsection
