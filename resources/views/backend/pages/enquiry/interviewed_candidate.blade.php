@extends('backend.layouts.app')
@section('title', config('app.name') . ' - Interviewed Candidates')

@section('content')
<div class="box">
    <div class="box-header with-border d-flex justify-content-between align-items-center">
        <div>
            <h3 class="box-title">Interviewed Candidates Information</h3>
            <h6 class="box-subtitle">This is the complete Interviewed Candidates List</h6>
        </div>
        <button type="button" class="btn btn-warning" id="addInterviewedCandidateBtn" data-toggle="modal" data-target="#interviewedCandidateModal">
            <i class="fa fa-plus"></i> Add Interviewed Candidate
        </button>
    </div>
    @include('backend.components.enquiry.interviewed_candidate_modal')
    <div class="box-body">
        <div class="table-responsive">
            <table id="interviewedDataTable" style="table-layout: fixed; width: 100%;" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                <thead>
                    <tr>
                        <th width="50px">Action</th>
                        <th>Serial</th>
                        <th>Phone</th>
                        <th>Full Name</th>
                        <th>Date Of Birth</th>
                        <th>Note</th>
                        <th>Entry Date</th>
                        <th>Entry By</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($candidates as $key => $candidate)
                    <tr>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bars"></i> Action
                                </button>
                                <div class="dropdown-menu">
                                    <button type="button" class="dropdown-item editInterviewedCandidateBtn" data-id="{{ $candidate->id }}">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                    <button type="button" class="dropdown-item text-danger deleteInterviewedCandidateBtn" data-id="{{ $candidate->id }}">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $candidate->phone }}</td>
                        <td>{{ $candidate->full_name }}</td>
                        <td>{{ $candidate->date_of_birth ? \Carbon\Carbon::parse($candidate->date_of_birth)->format('d, F Y') : 'N/A'  }}</td>
                        <td>{{ $candidate->note }}</td>
                        <td>{{ $candidate->created_at ? \Carbon\Carbon::parse($candidate->created_at)->format('d, F Y') : 'N/A'  }}</td>
                        <td>{{ $candidate->employee_id ? $candidate->employee->name : 'N/A'  }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- {{ $candidates->links() }} --}} <!-- Remove pagination for DataTables -->
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('backend/assets/vendor_components/datatable/datatables.min.js') }}"></script>
<script>
$(document).ready(function() {
    // Destroy DataTable if already initialized
    if ($.fn.DataTable.isDataTable('#interviewedDataTable')) {
        $('#interviewedDataTable').DataTable().clear().destroy();
    }
    $('#interviewedDataTable').DataTable({
        responsive: true,
        autoWidth: false,
        ordering: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        columnDefs: [
            { orderable: false, targets: 0 },
        ]
    });
    // Add Interviewed Candidate
    $('#addInterviewedCandidateBtn').on('click', function() {
        $('#interviewedCandidateForm')[0].reset();
        $('#interviewed_candidate_id').val('');
        $('#interviewedCandidateModalTitle').text('Add Interviewed Candidate');
        $('#interviewedCandidateModalSubmitText').text('Save');
        $('#interviewedCandidateModal').modal('show');
    });
    // Edit Interviewed Candidate
    $(document).on('click', '.editInterviewedCandidateBtn', function() {
        let id = $(this).data('id');
        $.get(`/admin/enquiry/interviewed-candidates/${id}`, function(res) {
            $('#interviewed_candidate_id').val(res.id);
            $('#phone').val(res.phone);
            $('#full_name').val(res.full_name);
            $('#date_of_birth').val(res.date_of_birth);
            $('#note').val(res.note);
            $('#interviewedCandidateModalTitle').text('Edit Interviewed Candidate');
            $('#interviewedCandidateModalSubmitText').text('Update');
            $('#interviewedCandidateModal').modal('show');
        });
    });
    // Save (Add/Edit) Interviewed Candidate
    $('#interviewedCandidateForm').on('submit', function(e) {
        e.preventDefault();
        let valid = true;
        $(this).find('.is-invalid').removeClass('is-invalid');
        $(this).find('.invalid-feedback').remove();
        const requiredFields = [
            { id: '#phone', name: 'Phone' },
            { id: '#full_name', name: 'Full Name' },
            { id: '#date_of_birth', name: 'Date Of Birth' }
        ];
        requiredFields.forEach(function (field) {
            const $input = $(field.id);
            let value = $input.val();
            if (!value || value === '') {
                valid = false;
                $input.addClass('is-invalid');
                $input.after('<div class="invalid-feedback" style="color: #e74c3c; font-size: 13px;">This field is required.</div>');
            }
        });
        if (!valid) {
            return;
        }
        let id = $('#interviewed_candidate_id').val();
        let isEdit = id && id !== '';
        let url = isEdit ? `/admin/enquiry/interviewed-candidates/${id}` : `/admin/enquiry/interviewed-candidates`;
        let method = isEdit ? 'POST' : 'POST';
        let formData = $(this).serializeArray();
        if (isEdit) {
            formData.push({ name: '_method', value: 'PUT' });
        }
        Swal.fire({
            title: isEdit ? 'Update Interviewed Candidate?' : 'Add Interviewed Candidate?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, proceed'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success' || response.message) {
                            $('#interviewedCandidateModal').modal('hide');
                            Swal.fire('Success!', response.message || 'Saved successfully.', 'success');
                            $('#interviewedCandidateForm')[0].reset();
                            $('#interviewed_candidate_id').val('');
                            location.reload();
                        } else {
                            Swal.fire('Error!', response.message || 'Failed to save.', 'error');
                        }
                    },
                    error: function(xhr) {
                        let message = 'Failed to save interviewed candidate.';
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
    // Delete Interviewed Candidate
    $(document).on('click', '.deleteInterviewedCandidateBtn', function() {
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
                    url: `/admin/enquiry/interviewed-candidates/${id}`,
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
});
</script>
@endsection 