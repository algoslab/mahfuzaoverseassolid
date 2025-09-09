@extends('backend.layouts.app')
@section('title', config('app.name') . ' - Phone Calls')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .wrap-text {
            white-space: normal !important;
            word-wrap: break-word !important;
            word-break: break-word !important;
        }

        .select2-container .select2-selection--single {
            height: 38px;
            padding: 6px 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
            right: 10px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 24px;
            padding-left: 0px;
            padding-top: 3px;
        }
    </style>
@endsection

@section('content')

    @if (session('status'))
        <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
            aria-hidden="true">
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
        <div class="box-header with-border d-flex justify-content-between align-items-center">
            <div>
                <h3 class="box-title">Phone Calls Information</h3>
                <h6 class="box-subtitle">This is the complete Phone Call List</h6>
            </div>
            <div>
                <button type="button" class="btn btn-warning" id="addPhoneCallBtn" data-toggle="modal"
                    data-target="#phoneCallModal">
                    <i class="fa fa-plus"></i> Add Phone Call
                </button>
                <button type="button" class="btn btn-success" id="employeeFeedbackReportBtn" data-toggle="modal"
                    data-target="#employeeFeedbackReportModal">
                    Employee Phone Call Feedback Report
                </button>
            </div>
        </div>

        @include('backend.components.enquiry.phone_call_modal', [
            'countries' => $countries ?? [],
            'candidateTypes' => $candidateTypes ?? [],
        ])

        @include('backend.components.enquiry.phone_call_followup_modal')

        @include('backend.components.enquiry.employee_feedback_report_modal')

        <div class="box-body">
            <div class="table-responsive">
                <table id="phoneCallDataTable" style="table-layout: fixed; width: 100%;"
                    class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                    <thead>
                        <tr>
                            <th width="4%">Action</th>
                            <th width="3%">Serial</th>
                            <th width="10%">Phone</th>
                            <th width="15%">Full Name</th>
                            <th width="25%">Note</th>
                            <th width="2%" title="In Candidate List">ICL</th>
                            <th width="5%" title="Followup Time">FT</th>
                            <th width="5%" title="Entry Type">ET</th>
                            <th width="8%">Next Date</th>
                            <th width="15%">Entry By</th>
                            <th width="8%">Process</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($phoneCalls as $key => $call)
                            <tr>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-bars"></i> Action
                                        </button>
                                        <div class="dropdown-menu">
                                            <button type="button" class="dropdown-item addFollowupBtn"
                                                data-id="{{ $call->id }}">
                                                <i class="fa fa-plus"></i> Add Follow Up
                                            </button>
                                            <button type="button" class="dropdown-item editPhoneCallBtn"
                                                data-id="{{ $call->id }}">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>
                                            <button type="button" class="dropdown-item text-danger deletePhoneCallBtn"
                                                data-id="{{ $call->id }}">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $call->phone ?? 'N/A' }}</td>
                                <td class="wrap-text">{{ $call->full_name ?? 'N/A' }}</td>
                                <td>{{ $call->note ?? 'N/A' }}</td>
                                <td>{{ $call->is_candidate ? 'Yes' : 'No' }}</td>
                                <td>{{ $call->followup_time ? \Carbon\Carbon::parse($call->followup_time)->format('g:i A') : 'N/A' }}</td>
                                <td>{{ $call->entry_type ?? 'N/A' }}</td>
                                <td>{{ $call->followup_date ? \Carbon\Carbon::parse($call->followup_date)->format('d, F Y') : 'N/A' }}</td>
                                <td>{{ $call->employee_id ? $call->employee->fast_name. ' '.$call->employee->last_name  : 'N/A' }}</td>
                                <td class="wrap-text">{{ $call->process ?? 'N/A' }}</td>
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
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#employeeFeedbackReportTable').DataTable();
            $('#phoneCallDataTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                responsive: true,
            });

            $('#phoneCallForm').on('submit', function (e) {
                let valid = true;
                $(this).find('.is-invalid').removeClass('is-invalid');
                $(this).find('.invalid-feedback').remove();

                const requiredFields = [
                    { id: '#phone', name: 'Phone' },
                    { id: '#full_name', name: 'Full Name' },
                    { id: '#country_id', name: 'Country' },
                    { id: '#candidate_type_id', name: 'Category' },
                    { id: '#how_find_us_id', name: 'How Find Us' }
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
                        $input.after('<div class="invalid-feedback" style="color: #e74c3c; font-size: 13px;">This field is required.</div>');
                    }
                });

                if (!valid) {
                    e.preventDefault();
                }
            });

            $('#phoneCallForm input, #phoneCallForm select').on('input change', function () {
                if ($(this).val()) {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').remove();
                    if ($(this).hasClass('select2')) {
                        $(this).next('.select2-container').find('.select2-selection').removeClass('is-invalid');
                    }
                }
            });
        });

        function fetchPhoneCalls() {
            if ($.fn.DataTable.isDataTable('#phoneCallDataTable')) {
                $('#phoneCallDataTable').DataTable().destroy();
            }
            $.ajax({
                url: '{{ route('admin.phone-calls.index') }}',
                type: 'GET',
                success: function(data) {
                    $('#phoneCallDataTable tbody').html(data.html);
                    $('#phoneCallDataTable').DataTable({
                        paging: true,
                        searching: true,
                        ordering: true,
                        responsive: true,
                    });
                },
                error: function() {
                    console.error('Failed to refresh phone call table.');
                }
            });
        }

        $(document).on('click', '.deletePhoneCallBtn', function() {
            const id = $(this).data('id');
            const url = '{{ route('admin.phone-calls.destroy', ':id') }}'.replace(':id', id);

            Swal.fire({
                title: 'Delete Phone Call?',
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
                        success: function(res) {
                            if (res.status === 'success') {
                                Swal.fire('Deleted!', res.message, 'success');
                                fetchPhoneCalls();
                            } else {
                                Swal.fire('Error!', res.message, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'Failed to delete.', 'error');
                        }
                    });
                }
            });
        });

        $(document).on('click', '#addPhoneCallBtn', function() {
            $('#phoneCallForm')[0].reset();
            $('#phone_call_id').val('');
            $('#phoneCallModalTitle').text('Add Phone Call');
            $('#phoneCallModalSubmitText').text('Save');
            $('#phoneCallModal').modal('show');
        });

        $(document).on('click', '.editPhoneCallBtn', function() {
            const id = $(this).data('id');
            const url = '{{ route('admin.phone-calls.show', ':id') }}'.replace(':id', id);
            $('#phoneCallForm')[0].reset();
            $('#phone_call_id').val(id);
            $('#phoneCallModalTitle').text('Edit Phone Call');
            $('#phoneCallModalSubmitText').text('Update');
            $.get(url, function(res) {
                $('#phone').val(res.phone ?? '');
                $('#email').val(res.email ?? '');
                $('#full_name').val(res.full_name ?? '');
                $('#country_id').val(res.country_id ?? '').trigger('change');
                $('#candidate_type_id').val(res.candidate_type_id ?? '').trigger('change');
                $('#note').val(res.note ?? '');
                $('#followup_date').val(res.followup_date ?? '');
                $('#how_find_us_id').val(res.how_find_us_id ?? '').trigger('change');
                $('#phoneCallModal').modal('show');
            });
        });

        $('#phoneCallForm').on('submit', function(e) {
            e.preventDefault();
            let id = $('#phone_call_id').val();
            let isEdit = id && id !== '';
            let url = isEdit ?
                '{{ route('admin.phone-calls.update', ':id') }}'.replace(':id', id) :
                '{{ route('admin.phone-calls.store') }}';
            let method = isEdit ? 'POST' : 'POST';
            let formData = $(this).serializeArray();
            if (isEdit) {
                formData.push({
                    name: '_method',
                    value: 'PUT'
                });
            }
            Swal.fire({
                title: isEdit ? 'Update Phone Call?' : 'Add Phone Call?',
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
                                $('#phoneCallModal').modal('hide');
                                Swal.fire('Success!', response.message || 'Saved successfully.',
                                    'success');
                                $('#phoneCallForm')[0].reset();
                                $('#phone_call_id').val('');
                                fetchPhoneCalls();
                            } else {
                                Swal.fire('Error!', response.message || 'Failed to save.',
                                    'error');
                            }
                        },
                        error: function(xhr) {
                            let message = 'Failed to save phone call.';
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

        $(document).on('click', '.addFollowupBtn', function() {
            const phoneCallId = $(this).data('id');
            $('#followup_phone_call_id').val(phoneCallId);
            $('#phoneCallFollowupForm')[0].reset();
            // Reset field visibility
            $('#followup_datee').closest('.form-group').show();
            $('#followup_time').closest('.form-group').show();
            $('#phoneCallFollowupModal').modal('show');
        });

        // Dynamic show/hide for followup date/time based on process
        $(document).on('change', '#process', function() {
            const processVal = $(this).val();
            if (processVal === 'Close') {
                $('#followup_datee').closest('.form-group').hide();
                $('#followup_time').closest('.form-group').hide();
            } else {
                $('#followup_datee').closest('.form-group').show();
                $('#followup_time').closest('.form-group').show();
            }
        });

        $('#phoneCallFollowupForm').on('submit', function(e) {
            let valid = true;
            $(this).find('.is-invalid').removeClass('is-invalid');
            $(this).find('.invalid-feedback').remove();

            const processVal = $('#process').val();
            if (!processVal) {
                valid = false;
                $('#process').addClass('is-invalid').after('<div class="invalid-feedback" style="color: #e74c3c; font-size: 13px;">This field is required.</div>');
            }
            if (processVal !== 'Close') {
                const followupDate = $('#followup_datee').val();
                if (!followupDate) {
                    valid = false;
                    $('#followup_datee').addClass('is-invalid').after('<div class="invalid-feedback" style="color: #e74c3c; font-size: 13px;">This field is required.</div>');
                }
            }
            if (!valid) {
                e.preventDefault();
                return;
            }
            let formDataArray = $('#phoneCallFollowupForm').serializeArray();
            let formDataObject = {};

            formDataArray.forEach(field => {
                if (field.name === 'followup_datee') {
                    formDataObject['followup_date'] = field.value; // Rename key
                } else {
                    formDataObject[field.name] = field.value;
                }
            });

            $.ajax({
                url: '/admin/enquiry/phone-call-followups',
                type: 'POST',
                data: formDataObject,
                success: function(response) {
                    if (response.status === 'success') {
                        $('#phoneCallFollowupModal').modal('hide');
                        Swal.fire('Success!', 'Follow up saved successfully.', 'success');
                        $('#phoneCallFollowupForm')[0].reset();
                        fetchPhoneCalls && fetchPhoneCalls();
                    } else {
                        Swal.fire('Error!', response.message || 'Failed to save follow up.', 'error');
                    }
                },
                error: function(xhr) {
                    let message = 'Failed to save follow up.';
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
        });

        $(function() {
            $('.show-followups').on('click', function(e) {
                e.preventDefault();
                var index = $(this).data('employee-index');
                var name = $(this).data('employee-name');
                $('#employee-feedback-list-section').hide();
                $('#employee-followup-accordion-section').show();
                $('.employee-followup-accordion').hide();
                $('.employee-followup-accordion[data-employee-index="' + index + '"]').show();
                $('#employeeFeedbackReportModalLabel').text('Number of Feedback Entry - ' + name);
                $('#followupAccordionHeader').text('Follow Up List for ' + name);
            });
            $('#backToListBtn').on('click', function() {
                $('#employee-followup-accordion-section').hide();
                $('#employee-feedback-list-section').show();
                $('#employeeFeedbackReportModalLabel').text('Employee Phone Call Feedback Report');
            });
            $('#employeeFeedbackReportModal').on('hidden.bs.modal', function() {
                $('#employee-followup-accordion-section').hide();
                $('#employee-feedback-list-section').show();
                $('#employeeFeedbackReportModalLabel').text('Employee Phone Call Feedback Report');
            });
        });
    </script>
@endsection
