@extends('backend.layouts.app')
@section('title', config('app.name') . ' - Investors')

@push('styles')
<style>
.dropdown-menu {
  max-height: 250px !important;
  overflow-y: auto !important;
}
</style>
@endpush

@section('content')
<style>
.custom-control-input:checked ~ .custom-control-label::before {
    background-color: #28a745;
    border-color: #28a745;
}

.custom-control-input:not(:checked) ~ .custom-control-label::before {
    background-color: #dc3545;
    border-color: #dc3545;
}

.custom-control-label {
    cursor: pointer;
    user-select: none;
}

#status-icon {
    margin-right: 5px;
    font-size: 14px;
}

.invalid-feedback {
    display: block !important;
    color: #dc3545;
    font-size: 13px;
    margin-top: 5px;
}

.is-invalid {
    border-color: #dc3545 !important;
}

.select2-container--default .select2-selection--single.is-invalid {
    border-color: #dc3545 !important;
}

.table-responsive {
  overflow: visible !important;
}
.table-responsive .dropdown-menu {
  max-height: 250px !important;
  overflow-y: auto !important;
}
</style>
<div class="box">
    <div class="box-header with-border d-flex justify-content-between align-items-center">
        <div>
            <h3 class="box-title">Investor Management</h3>
            <h6 class="box-subtitle">This is the complete Investor List</h6>
        </div>
        <button type="button" class="btn btn-warning" id="addInvestorBtn" data-toggle="modal" data-target="#investorModal">
            <i class="fa fa-plus"></i> Add Investor
        </button>
    </div>
    @include('backend.components.people.investor_modal')
    @include('backend.components.people.investor_profile_modal')
    @include('backend.components.people.make_transaction_modal')
    @include('backend.components.people.view_transactions_modal')
    <div class="box-body">
        <div class="table-responsive">
            <table id="investorDataTable" style="table-layout: fixed; width: 100%;" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                <thead>
                    <tr>
                        <th width="4%">Action</th>
                        <th width="3%">Serial</th>
                        <th width="10%">Name</th>
                        <th width="13%">Cell No</th>
                        <th width="15%">Email</th>
                        <th width="15%">Referred By Employee</th>
                        <th width="15%">Received Given</th>
                        <th width="15%">Opening Balance</th>
                        <th width="10%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($investors as $key => $investor)
                    <tr>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="dropdown" aria-haspopup="true" sr aria-expanded="false">
                                    <i class="fa fa-bars"></i> Action
                                </button>
                                <div class="dropdown-menu">
                                    <button type="button" class="dropdown-item viewProfile" data-id="{{ $investor->id }}">
                                        <i class="fa fa-user"></i> View Profile
                                    </button>
                                    <button type="button" class="dropdown-item viewTransactions" data-id="{{ $investor->id }}">
                                        <i class="fa fa-stream"></i> View Transactions
                                    </button>
                                    <button type="button" class="dropdown-item makeTransactions" data-id="{{ $investor->id }}">
                                        <i class="fa fa-stamp"></i> Make Transactions
                                    </button>
                                    <button type="button" class="dropdown-item editInvestorBtn" data-id="{{ $investor->id }}">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                    <button type="button" class="dropdown-item text-danger deleteInvestorBtn" data-id="{{ $investor->id }}">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $investor->name }}</td>
                        <td>{{ $investor->cell_no }}</td>
                        <td>{{ $investor->email }}</td>
                        <td>{{ $investor->employee_id ? $investor->employee->fast_name. ' '.$investor->employee->last_name  : 'N/A' }}</td>
                        <td>{{ $investor->recieved_no }}</td>
                        <td>{{ $investor->balance }}</td>
                        <td>{!! $investor->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' !!}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('backend/assets/vendor_components/datatable/datatables.min.js') }}"></script>
<script>
$(document).ready(function() {
    $('.select2').select2();
    if ($.fn.DataTable.isDataTable('#investorDataTable')) {
        $('#investorDataTable').DataTable().clear().destroy();
    }
    $('#investorDataTable').DataTable({
        responsive: true,
        autoWidth: false,
        ordering: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        columnDefs: [
            { orderable: false, targets: 0 },
        ]
    });

    // Status checkbox functionality
    $('#status').on('change', function() {
        const isChecked = $(this).is(':checked');
        const $icon = $('#status-icon');
        const $label = $(this).next('.custom-control-label');
        
        if (isChecked) {
            $icon.removeClass('fa-times text-danger').addClass('fa-check text-success');
            $label.html('<i class="fa fa-check text-success" id="status-icon" style="display: inline;"></i> Active');
        } else {
            $icon.removeClass('fa-check text-success').addClass('fa-times text-danger');
            $label.html('<i class="fa fa-times text-danger" id="status-icon" style="display: inline;"></i> Inactive');
        }
    });

    // Add Investor
    $('#addInvestorBtn').on('click', function() {
        $('#investorForm')[0].reset();
        $('#investor_id').val('');
        $('#status').prop('checked', true).trigger('change');
        $('.select2').val('').trigger('change');
        $('#investorModalTitle').text('Add Investor');
        $('#investorModalSubmitText').text('Save');
        $('#investorModal').modal('show');
    });

    // Edit Investor
    $(document).on('click', '.editInvestorBtn', function() {
        let id = $(this).data('id');
        $.get(`/admin/investors/${id}`, function(res) {
            $('#investor_id').val(res.id);
            $('#name').val(res.name);
            $('#cell_no').val(res.cell_no);
            $('#email').val(res.email);
            $('#password').val(''); // Don't populate password for security
            $('#current_address').val(res.current_address);
            $('#permanent_address').val(res.permanent_address);
            $('#note').val(res.note);
            
            // Set dropdown values
            $('#country_id').val(res.country_id).trigger('change');
            $('#division_id').val(res.division_id).trigger('change');
            $('#district_id').val(res.district_id).trigger('change');
            $('#employee_id').val(res.employee_id).trigger('change');
            
            // Set status checkbox
            $('#status').prop('checked', res.status == 1).trigger('change');
            
            $('#investorModalTitle').text('Edit Investor');
            $('#investorModalSubmitText').text('Update');
            $('#investorModal').modal('show');
        });
    });

    // Client-side validation
    $('#investorForm').on('submit', function(e) {
        e.preventDefault();
        
        let valid = true;
        $(this).find('.is-invalid').removeClass('is-invalid');
        $(this).find('.invalid-feedback').hide();

        const requiredFields = [
            { id: '#name', name: 'Name' },
            { id: '#email', name: 'Email' },
            { id: '#cell_no', name: 'Cell No' },
            { id: '#password', name: 'Password' },
            { id: '#country_id', name: 'Country' },
            { id: '#division_id', name: 'Division' },
            { id: '#district_id', name: 'District' },
            { id: '#employee_id', name: 'Employee' },
            { id: '#investor_photo', name: 'Investor Photo' },
            { id: '#nid_scan_copy', name: 'Nid Scan Copy' },
            { id: '#agreement_scan_copy', name: 'Agreement Scan Copy' },
            { id: '#status', name: 'Status' },
            { id: '#current_address', name: 'Current Address' },
            { id: '#permanent_address', name: 'Permanent Address' }
        ];

        requiredFields.forEach(function (field) {
            const $input = $(field.id);
            let value = $input.val();
            
            if (!value || value === '') {
                valid = false;
                $input.addClass('is-invalid');
                if ($input.hasClass('select2')) {
                    $input.next('.select2-container').find('.select2-selection').addClass('is-invalid');
                }
                $input.next('.invalid-feedback').html('This field is required.').show();
            }
        });

        // Email validation
        const email = $('#email').val();
        if (email && !isValidEmail(email)) {
            valid = false;
            $('#email').addClass('is-invalid');
            $('#email').next('.invalid-feedback').html('Please enter a valid email address.').show();
        }

        if (!valid) {
            return;
        }

        // Proceed with form submission
        let id = $('#investor_id').val();
        let isEdit = id && id !== '';
        let url = isEdit ? `/admin/investors/${id}` : `/admin/investors`;
        let method = isEdit ? 'POST' : 'POST';
        let formData = new FormData(this);
        if (isEdit) {
            formData.append('_method', 'PUT');
        }

        Swal.fire({
            title: isEdit ? 'Update Investor?' : 'Add Investor?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, proceed'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === 'success' || response.message) {
                            $('#investorModal').modal('hide');
                            Swal.fire('Success!', response.message || 'Saved successfully.', 'success');
                            $('#investorForm')[0].reset();
                            $('#investor_id').val('');
                            location.reload();
                        } else {
                            Swal.fire('Error!', response.message || 'Failed to save.', 'error');
                        }
                    },
                    error: function(xhr) {
                        let message = 'Failed to save investor.';
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

    // Clear validation errors on input
    $('#investorForm input, #investorForm select, #investorForm textarea').on('input change', function () {
        if ($(this).val()) {
            $(this).removeClass('is-invalid');
            $(this).next('.invalid-feedback').hide();
            if ($(this).hasClass('select2')) {
                $(this).next('.select2-container').find('.select2-selection').removeClass('is-invalid');
            }
        }
    });

    // Email validation function
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Delete Investor
    $(document).on('click', '.deleteInvestorBtn', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Delete Record?',
            text: "This cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/investors/${id}`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(res) {
                        Swal.fire('Deleted!', res.message, 'success').then(() => location.reload());
                    },
                    error: function() {
                        Swal.fire('Error!', 'Could not delete record.', 'error');
                    }
                });
            }
        });
    });

    // View Profile Modal Logic
    $(document).on('click', '.viewProfile', function() {
        var investorId = $(this).data('id');
        var investor = null;
        @foreach($investors as $inv)
            if ({{ $inv->id }} == investorId) {
                investor = @json($inv);
            }
        @endforeach
        if (investor && investor.employee) {
            var emp = investor.employee;
            var html = `<div class=\"row\">
                <div class=\"col-md-4 text-center\">
                    <img src=\"${emp.photo ? '/storage/' + emp.photo : '/public/images/avatar.png'}\" class=\"img-fluid rounded-circle mb-3\" style=\"width:120px;height:120px;object-fit:cover;\" alt=\"Employee Photo\">
                    <h5 class=\"mt-2\">${emp.first_name ?? ''} ${emp.last_name ?? ''}</h5>
                    <span class=\"badge ${emp.status == 1 ? 'badge-success' : 'badge-danger'}\">${emp.status == 1 ? 'Active' : 'Inactive'}</span>
                </div>
                <div class=\"col-md-8\">
                    <table class=\"table table-bordered\">
                        <tr><th>Email</th><td>${emp.personal_email ?? 'N/A'}</td></tr>
                        <tr><th>Phone</th><td>${emp.personal_phone ?? 'N/A'}</td></tr>
                        <tr><th>Designation</th><td>${emp.designation ? emp.designation.name : 'N/A'}</td></tr>
                        <tr><th>Department</th><td>${emp.department ? emp.department.name : 'N/A'}</td></tr>
                        <tr><th>Branch</th><td>${emp.branch ? emp.branch.name : 'N/A'}</td></tr>
                        <tr><th>Gender</th><td>${emp.gender ?? 'N/A'}</td></tr>
                        <tr><th>Date of Birth</th><td>${emp.date_of_birth ?? 'N/A'}</td></tr>
                        <tr><th>Current Address</th><td>${emp.current_address ?? 'N/A'}</td></tr>
                        <tr><th>Permanent Address</th><td>${emp.permanent_address ?? 'N/A'}</td></tr>
                        <tr><th>Employee Code</th><td>${emp.employee_code ?? 'N/A'}</td></tr>
                        <tr><th>Joining Date</th><td>${emp.date_of_joining ?? 'N/A'}</td></tr>
                        <tr><th>Blood Group</th><td>${emp.blood_group ?? 'N/A'}</td></tr>
                        <tr><th>Religion</th><td>${emp.religion ?? 'N/A'}</td></tr>
                        <tr><th>Marital Status</th><td>${emp.marital_status ?? 'N/A'}</td></tr>
                        <tr><th>NID Number</th><td>${emp.nid_number ?? 'N/A'}</td></tr>
                        <tr><th>Note</th><td>${emp.note ?? 'N/A'}</td></tr>
                    </table>
                </div>
            </div>`;
            $('#profileContent').html(html);
        } else {
            $('#profileContent').html('<div class=\"alert alert-warning\">No employee information found for this investor.</div>');
        }
        $('#viewProfileModal').modal('show');
    });

    // Transaction Modals Integration
    $(document).on('click', '.makeTransactions', function() {
        const investorId = $(this).data('id');
        $('#makeTransactionForm')[0].reset();
        $('#makeTransactionModal').modal('show');
        $('#makeTransactionForm').data('investor-id', investorId);
        // Optionally, load dynamic options for select fields here
    });

    $(document).on('submit', '#makeTransactionForm', function(e) {
        e.preventDefault();
        const investorId = $(this).data('investor-id');
        const formData = new FormData(this);
        $.ajax({
            url: `/admin/investors/${investorId}/transactions`,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                $('#makeTransactionModal').modal('hide');
                toastr.success('Transaction saved successfully!');
            },
            error: function(xhr) {
                toastr.error('Failed to save transaction.');
            }
        });
    });

    $(document).on('click', '.viewTransactions', function() {
        const investorId = $(this).data('id');
        $('#viewTransactionsModal').modal('show');
        $.get(`/admin/investors/${investorId}/transactions`, function(transactions) {
            let rows = '';
            transactions.forEach(function(tx, idx) {
                rows += `<tr>
                    <td>${idx + 1}</td>
                    <td>${tx.transaction_type}</td>
                    <td>${tx.payment_method}</td>
                    <td>${tx.currency}</td>
                    <td>${tx.amount}</td>
                    <td>${tx.bdt_amount}</td>
                    <td>${tx.candidate ? tx.candidate.name : ''}</td>
                    <td>${tx.attachment ? `<a href='/storage/${tx.attachment}' target='_blank'>View</a>` : ''}</td>
                    <td>${tx.transaction_note || ''}</td>
                    <td>${tx.note || ''}</td>
                    <td>${tx.created_at}</td>
                </tr>`;
            });
            $('#transactionsTable tbody').html(rows);
        });
    });
});
</script>
@endsection 