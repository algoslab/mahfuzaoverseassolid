@extends('backend.layouts.app')
@section('title', config('app.name') . ' - delegateOffice')

@section('style')
    <style>
        .wrap-text {
            white-space: normal !important;
            word-wrap: break-word !important;
            word-break: break-word !important;
        }
    </style>
    <style>
        .branding {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .branding span.text-danger {
            color: red;
        }

        .info-label {
            font-weight: 600;
        }

        .card-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .btn-print {
            float: right;
        }

        @media print {
            .btn-print {
                display: none;
            }
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
            <h3 class="box-title">Delegates Office Information</h3>
            <h6 class="box-subtitle">This is all Delegate Office List</h6>
        </div>
        <button type="button" class="btn btn-warning addDelegateButton" data-toggle="modal" data-target="#modal-center">
            <i class="fa-solid fa-plus"></i> Add Data
        </button>
    </div>

    @include('backend.components.people.delegate_office_modal')

    <div class="box-body">
        <div class="table-responsive">
            <table id="customDataTable" style="table-layout: fixed; width: 100%;" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                <thead>
                    <tr>
                        <th style="">Action</th>
                        <th style="">Serial</th>
                        <th style="">Delegate</th>
                        <th style="">Branch</th>
                        <th style="">Office</th>
                        <th style="">Number</th>
                        <th style="">Address</th>
                        <th style="">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($delegateOffice as $key =>$data)
                    <tr>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bars"></i> Action
                                </button>
                                <div class="dropdown-menu">
  
                                
                                    <a href="#" class="dropdown-item text-danger deleteDelegateBtn" data-id="{{ $data->id }}">
                                        <i class="fa fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </td>
                        
                        <td>{{ $key + 1 }}</td>
                        <td class="wrap-text">{{ $data->delegate->first_name  }} {{ $data->delegate->last_name  }} </td>
                        <td class="wrap-text">{{ $data->branch->name}}</td>
                        <td class="wrap-text">{{ $data->office_name}}</td>
                        <td class="wrap-text">{{ $data->contact_number}}</td>
                        <td class="wrap-text">{{ $data->address}}</td>
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
            $('#modal-center').on('shown.bs.modal', function () {
                $('.wrapper').removeAttr('aria-hidden');
            });
            $('#modal-center').on('hidden.bs.modal', function () {
                $('.wrapper').attr('aria-hidden', 'true');
            });

            function fetchDelegats() {
                $.ajax({
                    url: '{{ route("admin.delegateOffice.index") }}',
                    type: 'GET',
                    success: function (data) {
                        let newBody = $(data).find('table tbody').html();
                        $('#customDataTable tbody').html(newBody);
                    },
                    error: function () {
                        console.error('Failed to refresh agent table.');
                    }
                });
            }
            fetchCountriess();
            fetchDivisions();
            fetchDistricts();
            fetchThanas();
            fetchEmployees();
            fetchBranch();
            fetchAgents();
            fetchDelegates();

            $(document).ready(function () {
                $('#delegateOfficeForm').on('submit', function (e) {
                    e.preventDefault();

                    let isEdit = $('#delegate_office_id').val() !== '';
                    let formData = new FormData(this);
                    let id = $('#delegate_office_id').val();

                    let url = isEdit
                        ? `{{ route('admin.delegateOffice.update', ['delegateOffice' => '__id__']) }}`.replace('__id__', id)
                        : `{{ route('admin.delegateOffice.store') }}`;

                    if (isEdit) {
                        formData.append('_method', 'PUT');
                    }

                    Swal.fire({
                        title: isEdit ? "Update Delegate Office ?" : "Add Delegate Office?",
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
                                        $('#delegateOfficeForm')[0].reset();
                                        $('#delegate_office_id').val('');
                                        fetchDelegats();
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function (xhr) {
                                    let message = 'Failed to save Delegate.';

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

                $(document).on('click', '.addDelegateButton', function () {
                    $('#delegateOfficeForm')[0].reset();
                    $('#delegate_office_id').val('');
                    $('#modalTitle').text('Add Delegate Office Information');
                    $('#sponsor_type').on('change', function () {
                        let selectedType = $(this).val();
                        $('.type-field').hide();
                        $('.type-' + selectedType).show();
                    });
                    
                });


                $(document).on('click', '.deleteDelegateBtn', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("admin.delegateOffice.destroy", ":id") }}'.replace(':id', id);

                    Swal.fire({
                        title: 'Delete Delegate Office?',
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
                                        fetchDelegats();
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


                $('#delegateSelect').on('change', function () {
                    const delegateShowUrl = "{{ route('admin.delegates.show', ':id') }}";
                    const baseUrl = "{{ url('/storage') }}/"; 
                    const delegateId = $(this).val();
                    
                    if (delegateId) {
                         const DataShow = delegateShowUrl.replace(':id', delegateId);
                        $.ajax({
                            url: DataShow, 
                            type: 'GET',
                            success: function (data) {
                                $('#delegate_name').text(': ' + (data.first_name ?? ''));
                                $('#delegate_phone').text(': ' + (data.phone_number ?? ''));
                                $('#delegate_email').text(': ' + (data.email ?? ''));
                                $('#delegate_country').text(': ' + (data.country?.name ?? ''));
                                $('#delegate_address').text(': ' + (data.current_address ?? ''));
                                $('#delegate_balance').text(': ' + (data.opening_balance ?? ''));
                                $('#delegate_branchId').val(data.branch_id ?? '');

                                // Update photo and balance sheet images
                                const photoUrl = data.delegate_photo ? baseUrl + data.delegate_photo : 'https://via.placeholder.com/130x100?text=Card';
                                const balanceSheetUrl = data.opening_balance_sheet ? baseUrl + data.opening_balance_sheet : '';

                                $('#delegate_photo').attr('src', photoUrl);
                                $('#balance_sheet').attr('src', balanceSheetUrl);
                            },
                            error: function (xhr) {
                                console.error('Error fetching delegate details:', xhr.responseText);

                                // Clear fields on error
                                $('#delegate_name, #delegate_phone, #delegate_email, #delegate_country, #delegate_address, #delegate_balance, #delegate_branchId').text(': ');
                                $('#delegate_photo').attr('src', 'https://via.placeholder.com/130x100?text=Card');
                                $('#balance_sheet').attr('src', '');
                            }
                        });
                    }
                });
                

                
            });

        </script>

    @endsection
@endsection
