@extends('supper_admin.layouts.app')
@section('title', config('app.name') . ' - Company')

@section('style')
    <style>
        .wrap-text {
            white-space: normal !important;
            word-wrap: break-word !important;
            word-break: break-word !important;
        }
        .modal-wider {
            max-width: 1000px; 
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

@include('supper_admin.components.companies.view_modal')

<div class="box">
    <!-- Header Section -->
    <div class="box-header with-border d-flex justify-content-between align-items-center">
        <div>
            <h3 class="box-title">Company List</h3>
            <h6 class="box-subtitle">This is all Company List</h6>
        </div>
        {{-- <button type="button" class="btn btn-warning addBlogButton" data-toggle="modal" data-target="#modal-center">
            <i class="fa-solid fa-plus"></i> Add Company
        </button> --}}
    </div>

    <div class="box-body">
        <div class="table-responsive">
            <table id="customDataTable" style="table-layout: fixed; width: 100%;" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                <thead>
                    <tr>
                        <th style="width: 5%;">Id</th>
                        <th style="width: 15%;">Name</th>
                        <th style="width: 10%;">Code</th>
                        <th style="width: 20%;">Start Date</th>
                        <th style="width: 20%;">Contact Number</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 10%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingCompany as $key => $company)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $company->company_name}}</td>

                        <td class="wrap-text">{{ $company->company_code  }}</td>
                        <td class="wrap-text">{{ $company->start_date }}</td>
                        <td class="wrap-text">{{ $company->contact_number }}</td>
                        <td>
                            <button class="btn btn-sm" id="modalChangeStatusBtn" data-id="{{ $company->id }}" data-status="{{ $company->status }}">
                                <span class="badge {{ $company->status == 1 ? 'badge-success' : 'badge-danger' }}">
                                    {{ $company->status == 1 ? 'Active' : 'Inactive' }}
                                </span>
                            </button>
                        </td>
                        <td>
                            <button type="button" onclick="showCompanyInfo({{ $company->id }})" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-left">
                                View
                            </button>
                            <button type="button" class="btn btn-info btn-sm editBlogButton" data-toggle="modal" data-target="#modal-center"
                            data-id="{{ $company->id }}">
                            Edit
                            </button>
                            <form action="{{ route('companies.destroy', $company->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this Blog?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div>
</div>

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {

        // Bind click event on change-status button inside the modal
        $('#modalChangeStatusBtn').click(function () {
            var companyId = $(this).data('id');
            var currentStatus = $(this).data('status');
            var newStatus = currentStatus == 1 ? 0 : 1;

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to change the company status?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, change it!',
                cancelButtonText: 'No, keep it',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('companies.update', '') }}/" + companyId,
                        type: "PUT",
                        data: {
                            _token: "{{ csrf_token() }}",
                            status: newStatus
                        },
                        success: function (response) {
                            // Update button's data attribute in modal
                            $('#modalChangeStatusBtn').data('status', newStatus);

                            // Update badge inside modal
                            $('#statusBadge')
                                .removeClass('badge-success badge-danger')
                                .addClass(newStatus == 1 ? 'badge-success' : 'badge-danger')
                                .text(newStatus == 1 ? 'Active' : 'Inactive');

                            // 🟡 Update the status badge in the table row dynamically
                            const tableBadge = $('button[data-id="' + companyId + '"] span.badge');
                            tableBadge
                                .removeClass('badge-success badge-danger')
                                .addClass(newStatus == 1 ? 'badge-success' : 'badge-danger')
                                .text(newStatus == 1 ? 'Active' : 'Inactive');

                            // Also update data-status attribute
                            $('button[data-id="' + companyId + '"]').data('status', newStatus);

                            // Success alert
                            Swal.fire('Updated!', response.message, 'success');
                        },

                        error: function () {
                            Swal.fire('Error!', 'Something went wrong!', 'error');
                        }
                    });
                } else {
                    Swal.fire('Cancelled', 'The company status was not changed.', 'info');
                }
            });
        });
    });

    function showCompanyInfo(id) {
        const url = '{{ route("supper_admin.companies.show", ":id") }}'.replace(':id', id);
        const storageBaseUrl = "{{ asset('storage') }}/";

        $.ajax({
            url: url,
            type: 'GET',
            success: function (data) {
                // Fill modal fields
                $('#companyName').text(data.company_name);
                $('#companyCode').text(data.company_code);
                $('#email').text(data.email);
                $('#contactNumber').text(data.contact_number);
                $('#alternateNumber').text(data.alternate_number);
                $('#ownerName').text(data.owner_name);
                $('#ownerNumber').text(data.owner_number);
                $('#ownerEmail').text(data.owner_email);
                $('#address').text(`${data.city}, ${data.district}, ${data.country}, ${data.zip_code}`);
                $('#nidNo').text(data.nid_no);
                $('#comments').text(data.comments);
                $('#statusBadge')
                    .removeClass('badge-success badge-danger')
                    .addClass(data.status == 1 ? 'badge-success' : 'badge-danger')
                    .text(data.status == 1 ? 'Active' : 'Inactive');

                $('#nidPhoto').attr('src', storageBaseUrl + data.nid_photo);

                // Set data-id and data-status for status button
                $('#modalChangeStatusBtn').data('id', data.id).data('status', data.status);

                // Show modal
                $('#modal-left').modal('show');
            },
            error: function (err) {
                console.error('Failed to fetch company info', err);
                Swal.fire('Error!', 'Unable to fetch company info.', 'error');
            }
        });
    }
</script>

@endsection



@endsection
