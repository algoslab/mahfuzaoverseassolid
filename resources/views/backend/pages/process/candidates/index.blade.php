@extends('backend.layouts.app')
@section('title', config('app.name') . ' - Candidates')

@section('style')
    <style>
        /* Start::datatable */
        .dataTables_wrapper .form-control {
            margin: 0 0;
            padding: 5px 5px 5px 5px;
        }
        .table-responsive {
            overflow: visible !important;
        }
        .table-responsive .dropdown-menu {
            position: absolute !important;
            z-index: 1050;
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .table-responsive .dropdown-menu .dropdown-item {
            padding: 3px 10px;
            margin: 3px 0;
            text-transform: capitalize;
        }
        .table-responsive .dropdown-menu .dropdown-item:hover {
            background-color: #f5a4a4;
            color: #000;
            border-radius: 4px;
        }
        /* End::datatable */

        /* Start::candidate profile view */
        .profile-image-wrapper {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }
        .profile-image-wrapper .overlay {
            position: absolute;
            top: 0;
            width: 250px;
            height: 250px;
            background: rgba(102, 98, 98, 0.6);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 50%;
            text-align: center;
            font-size: 16px;
            padding: 10px;
        }
        .profile-image-wrapper:hover .overlay {
            opacity: 1;
        }
        /* End::candidate profile view */

        /* Start::sweetalert2 */
        .swal2-popup {
            padding: 1.2em 1.2em !important;
            font-size: 0.95rem !important;
            width: 20em !important;
        }
        .swal2-title {
            font-size: 1.1rem !important;
        }
        .swal2-btn {
            font-size: 0.9rem !important;
            padding: 0.3em 1.2em !important;
        }
        /* End::sweetalert2 */
    </style>
@endsection

@section('content')
<div class="box">
    <div class="box-header with-border d-flex justify-content-between align-items-center">
        <div>
            <h3 class="box-title">Candidates Information</h3>
            <h6 class="box-subtitle">This is all Candidate List</h6>
        </div>
        <a href="{{ route('admin.candidates.create') }}" type="button" class="btn btn-md btn-warning addAgentButton" >
            <i class="fa-solid fa-plus"></i> Add Candidates
        </a>
    </div>

    <div class="box-body">
        <div class="table-responsive">
            <table id="candidateDataTable" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                <thead>
                    <tr>
                        <th style="width: 30px;">ID</th>
                        <th>Name</th>
                        <th>Agent</th>
                        <th>Age-Gender</th>
                        <th>NID</th>
                        <th>Passport</th>
                        <th>Validity</th>
                        <th>Interested Country</th>
                        <th>Interested Job</th>
                        <th>Process</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@include('backend.pages.process.candidates.partials.candidate_profile_modal')
@include('backend.pages.process.candidates.partials.agent_profile_modal')
@include('backend.pages.process.candidates.partials.candidate_commission_setup_modal')
@include('backend.pages.process.candidates.partials.candidate_type_transfer_modal', ['candidateTypes' => $candidateTypes])
@include('backend.pages.process.candidates.partials.candidate_comments_modal')
@include('backend.pages.process.candidates.partials.candidate_transaction_list_modal')
@include('backend.pages.process.candidates.partials.candidate_transaction_modal', ['transactionPurposes' => $transactionPurposes])
@include('backend.pages.process.candidates.partials.agent_transaction_list_modal')
@include('backend.pages.process.candidates.partials.agent_transaction_modal', ['careCandidates' => $careCandidates])
@endsection

@section('script')
{{-- Start::candidate datatable --}}
<script type="text/javascript">
    let datatable_columns = [
        { data: 'DT_RowIndex',name:"DT_RowIndex", orderable: false, searchable: false },
        { data: 'name', name: 'name', defaultContent: '' },
        { data: 'agent', name: 'agent', defaultContent: '' },
        { data: 'age_gender', name: 'age_gender', defaultContent: '' },
        { data: 'nid', name: 'personalInfo.nid_or_birth_certificate', defaultContent: '' },
        { data: 'passport', name: 'passport.passport_number', defaultContent: '' },
        { data: 'passport_validity', name: 'passport.passport_expired_date', defaultContent: '' },
        { data: 'interested_country', name: 'interested_country', defaultContent: '' },
        { data: 'interested_profession', name: 'interested_profession', defaultContent: '' },
        { data: 'status', name: 'status', orderable: false, searchable: false },
        { data: 'action', name: 'action', orderable: false, searchable: false }
    ]

    let datatable_columns_defs = [
        {'bSortable': true, 'aTargets': [0,1,2,3,4]},
        {'bSearchable': false, 'aTargets': [0]},
        { className: 'text-center', targets: [9,10] },
        { className: 'text-uppercase', targets: [1,2] },
    ]

    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    var dtTable = $('#candidateDataTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 25,
        serverMethod: 'get',
        lengthMenu: [10, 25, 50,100],
        order: [ 0, "asc" ],
        language: {
            'loadingRecords': '&nbsp;',
            'processing': 'Loading ...'
        },
        ajax: {
            url: '{{ route('admin.candidates.index') }}',
            type: 'get',
            dataType: 'JSON',
            cache: true,
        },
        columns: datatable_columns,
        search: {
            "regex": true
        },
        columnDefs: datatable_columns_defs,

        dom: "<'row mb-3'<'col-sm-12 text-right'B>>" +   // Buttons top-right
        "<'row mb-2'<'col-sm-6'l><'col-sm-6'f>>" +   // Length left, Search right
        "<'row'<'col-sm-12'tr>>" +                   // Table
        "<'row mt-2'<'col-sm-5'i><'col-sm-7'p>>",    // Info left, Pagination right

        buttons: [
            {
                extend: 'copy',
                className: 'btn btn-md btn-warning'
            },
            {
                extend: 'csv',
                className: 'btn btn-md btn-warning'
            },
            {
                extend: 'excel',
                className: 'btn btn-md btn-warning'
            },
            {
                extend: 'pdf',
                className: 'btn btn-md btn-warning'
            },
            {
                extend: 'print',
                className: 'btn btn-md btn-warning'
            }
        ]

    });
</script>
{{-- End::candidate datatable --}}

{{-- Start::candidate profile view modal --}}
<script>
    $(document).on('click', '.view-profile-btn', function(e) {
        e.preventDefault();
        const candidateId = $(this).data('id');

        // Optional: show loading
        $('#modalContent').html('<p>Loading...</p>');

        // Fetch candidate details
        $.ajax({
            url: '/admin/candidates/' + candidateId,
            type: 'GET',
            success: function(response) {
                console.log(response);

                $('#modalContent').html(response);
            },
            error: function() {
                $('#modalContent').html('<p class="text-danger">Failed to load candidate profile.</p>');
            }
        });
    });

    $(document).on('click', '.view-agent-profile-btn', function(e) {
        e.preventDefault();
        const agentId = $(this).data('id');

        // Optional: show loading
        $('#agentModalContent').html('<p>Loading...</p>');

        // Fetch candidate details
        $.ajax({
            url: '/admin/show-agent-profile/' + agentId,
            type: 'GET',
            success: function(response) {
                console.log(response);

                $('#agentModalContent').html(response);
            },
            error: function() {
                $('#agentModalContent').html('<p class="text-danger">Failed to load agent profile.</p>');
            }
        });
    });

    $(document).on('change', '#candidate_photo_update', function() {
        const [file] = this.files;
        if (file) {
            $('#candidate_photo_preview').attr('src', URL.createObjectURL(file));
        }
        // Automatically upload the image
        var form = $('#candidatePhotoForm')[0];
        var formData = new FormData(form);
        $.ajax({
            url: '/admin/candidates/update-candidate-photo',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.status === 'success') {
                    if(response.photo_url) {
                        $('#candidate_photo_preview').attr('src', response.photo_url);
                    }
                } else {
                    alert('Failed to update photo.');
                }
            },
            error: function(xhr) {
                let msg = 'Error uploading photo.';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    msg = Object.values(xhr.responseJSON.errors).join('\n');
                }
                alert(msg);
            }
        });
    });
</script>
{{-- End::candidate profile view modal --}}

{{-- Start::candidate type transfer --}}
<script>
    // Open modal and set candidate ID
    $(document).on('click', '.candidate-type-transfer-btn', function(e) {
        e.preventDefault();
        var candidateId = $(this).data('id');
        var currentType = $(this).data('current-type') || '';
        $('#transfer_candidate_id').val(candidateId);
        $('#current_candidate_type').val(currentType);
        $('#candidateTypeTransferModal').modal('show');
    });

    $(document).on('click', '.candidate-commission-setup-btn', function(e) {
        e.preventDefault();
        var candidateId = $(this).data('id');
        var currentCommission = $(this).data('commission') || '';
        var name = $(this).data('name') || '';
        $('#commission_candidate_id').val(candidateId);
        $('#current_candidate_commission').val(currentCommission);
        $('#candidate_name_modal_title').text(name);
        $('#candidateCommissionSetupModal').modal('show');
    });

    // Handle form submit
    $(document).on('submit', '#candidateCommissionSetupForm', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: '/admin/candidates/commission-setup',
            type: 'POST',
            data: formData,
            success: function(response) {
                if(response.status === 'success') {
                    $('#candidateCommissionSetupModal').modal('hide');
                    Swal.fire({
                        position: "center",
                        icon: 'success',
                        title: 'Success',
                        text: 'Candidate commission setup successfully!',
                        customClass: {
                            popup: 'swal2-popup',
                            title: 'swal2-title',
                            confirmButton: 'swal2-btn'
                        }
                    });

                    // Reload the page
                    setTimeout(function() {
                        // location.reload();
                        dtTable.ajax.reload(null, false); // reload yajra datatable
                    }, 1000);
                } else {
                    Swal.fire({
                        position: "center",
                        icon: 'error',
                        title: 'Failed',
                        text: 'Failed to setup candidate commission.',
                        customClass: {
                            popup: 'swal2-popup',
                            title: 'swal2-title',
                            confirmButton: 'swal2-btn'
                        }
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    position: "center",
                    icon: 'error',
                    title: 'Error',
                    text: (xhr.responseJSON?.message || 'Unknown error'),
                    customClass: {
                        popup: 'swal2-popup',
                        title: 'swal2-title',
                        confirmButton: 'swal2-btn'
                    }
                });
            }
        });
    });

    // Handle form submit
    $(document).on('submit', '#candidateTypeTransferForm', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: '/admin/candidates/type-transfer',
            type: 'POST',
            data: formData,
            success: function(response) {
                if(response.status === 'success') {
                    $('#candidateTypeTransferModal').modal('hide');
                    Swal.fire({
                        position: "center",
                        icon: 'success',
                        title: 'Success',
                        text: 'Candidate type transferred!',
                        customClass: {
                            popup: 'swal2-popup',
                            title: 'swal2-title',
                            confirmButton: 'swal2-btn'
                        }
                    });

                    // Reload the page
                    setTimeout(function() {
                        // location.reload();
                        $('#candidate_type_id').val('').trigger('change'); // reset select2 if used
                        dtTable.ajax.reload(null, false); // reload yajra datatable
                    }, 1000);
                } else {
                    Swal.fire({
                        position: "center",
                        icon: 'error',
                        title: 'Failed',
                        text: 'Failed to transfer candidate type.',
                        customClass: {
                            popup: 'swal2-popup',
                            title: 'swal2-title',
                            confirmButton: 'swal2-btn'
                        }
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    position: "center",
                    icon: 'error',
                    title: 'Error',
                    text: (xhr.responseJSON?.message || 'Unknown error'),
                    customClass: {
                        popup: 'swal2-popup',
                        title: 'swal2-title',
                        confirmButton: 'swal2-btn'
                    }
                });
            }
        });
    });

    $(document).on('click', '.deleteBonusBtn', function () {
        const id = $(this).data('id');
        const url = '{{ route("admin.candidates.destroy", ":id") }}'.replace(':id', id);

        Swal.fire({
            title: 'Delete Candidate?',
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
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            Swal.fire('Deleted!', response.message, 'success');
                            fetchTickets();
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error!', 'Failed to delete the ticket.', 'error');
                    }
                });
            }
        });
    });
</script>
{{-- End::candidate type transfer --}}

{{-- Start::candidate comments --}}
<script>
    $(document).on('click', '.candidate-comments-btn', function(e) {
        e.preventDefault();
        var candidateId = $(this).data('id');
        $('#comments_candidate_id').val(candidateId);
        $('#new_comment').val('');
        $('#candidateCommentsModal').modal('show');

        $.get(`/admin/candidates/comment/${candidateId}`, function(response) {
            $('#new_comment').val(response.comment || '');
        });
    });

    $(document).on('submit', '#candidateCommentsForm', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: '/admin/candidates/comment',
            type: 'POST',
            data: formData,
            success: function(response) {
                if(response.status === 'success') {
                    $('#candidateCommentsModal').modal('hide');
                    Swal.fire({
                        position: "center",
                        icon: 'success',
                        title: 'Success',
                        text: 'Comments saved successfully!',
                        customClass: {
                            popup: 'swal2-popup',
                            title: 'swal2-title',
                            confirmButton: 'swal2-btn'
                        }
                    });
                } else {
                    Swal.fire({
                        position: "center",
                        icon: 'error',
                        title: 'Failed',
                        text: 'Failed to saved comments.',
                        customClass: {
                            popup: 'swal2-popup',
                            title: 'swal2-title',
                            confirmButton: 'swal2-btn'
                        }
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    position: "center",
                    icon: 'error',
                    title: 'Error',
                    text: (xhr.responseJSON?.message || 'Unknown error'),
                    customClass: {
                        popup: 'swal2-popup',
                        title: 'swal2-title',
                        confirmButton: 'swal2-btn'
                    }
                });
            }
        });
    });
</script>
{{-- End::candidate comments --}}

{{-- Start::candidate transaction create --}}
<script>
    $(document).on('click', '.make-transaction-btn', function(e) {
        e.preventDefault();
        var candidateId = $(this).data('id');
        var candidateName = $(this).data('name') || '';

        // Set the modal title
        $('#candidateTransactionModalLabel').text('Make New Transaction with - ' + candidateName);

        $('#transaction_candidate_id').val(candidateId);
        $('#candidateTransactionForm')[0].reset();
        $('#candidateTransactionModal').modal('show');
    });

    $(document).on('click', '.make-agent-transaction-btn', function(e) {
        e.preventDefault();
        var candidateId = $(this).data('id');
        var agentId = $(this).data('referral_agent_id');
        var agentName = $(this).data('name') || '';

        // Set the modal title
        $('#agentTransactionModalLabel').text('Make New Transaction with - ' + agentName);

        $('#agent_transaction_candidate_id').val(candidateId);
        $('#agent_candidate_id').val(agentId);
        $('#agentTransactionForm')[0].reset();
        $('#agentTransactionModal').modal('show');
    });

    // fetch currency rates
    let currentRate = null; // Global variable
    function fetchCurrencyRates() {
        let dataExchangeApiKey = "{{ config('services.exchange.key') }}";
        let currency = $('#currency_select').val();
        $.ajax({
            url: `https://v6.exchangerate-api.com/v6/${dataExchangeApiKey}/latest/${currency}`,
            method: 'GET',
            success: function(data) {
                let rate = data.conversion_rates['BDT'];
                currentRate = rate; // save globally

                // Update currency rate display
                $('#currency_rate_info').text(`(1 ${currency} = ${rate} BDT)`);

                updateCurrencyInfoAndAmount();
            },
            error: function() {
                console.warn("Failed to fetch currency rates.");
            }
        });
    };

    function updateCurrencyInfoAndAmount() {
        let amount = parseFloat($('#amount').val()) || 0;

        if (currentRate === null) {
            $('#amount_bdt').val('');
            return;
        }

        // Calculate BDT amount
        let bdt = (amount * currentRate).toFixed(2);
        $('#amount_bdt').val(bdt);
    }

    $('#currency_select').on('input change', function () {
        fetchCurrencyRates();
    });

    $('#amount').on('input change', function () {
        updateCurrencyInfoAndAmount();
    });

    $(document).on('submit', '#candidateTransactionForm', function(e) {
        e.preventDefault();

        var form = $(this);
        var formData = new FormData(this);

        // Clear previous errors
        form.find('.invalid-feedback').text('');
        form.find('.is-invalid').removeClass('is-invalid');

        var $btn = form.find('button[type="submit"]');
        $btn.prop('disabled', true).text('Saving...');

        $.ajax({
            url: '/admin/candidates/transaction',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $btn.prop('disabled', false).text('Save Transaction');
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Transaction saved successfully!',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    $('#candidateTransactionModal').modal('hide');
                    form[0].reset();
                } else {
                    // Handle other server-side errors (not validation)
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Failed to save transaction.'
                    });
                }
            },
            error: function(xhr) {
                $btn.prop('disabled', false).text('Save Transaction');
                if (xhr.status === 422) {
                    // Validation error
                    let errors = xhr.responseJSON.errors;
                    for (let field in errors) {
                        let input = $('[name="' + field + '"]');

                        if (input.length) {
                            input.addClass('is-invalid');

                            // If it's a select2, place error after the select2 container
                            if (input.hasClass('select2-hidden-accessible')) {
                                let select2Container = input.next('.select2');
                                if (select2Container.length) {
                                    select2Container.after('<div class="invalid-feedback d-block">' + errors[field][0] + '</div>');
                                } else {
                                    // fallback
                                    input.after('<div class="invalid-feedback d-block">' + errors[field][0] + '</div>');
                                }
                            }
                            // If inside an input-group (e.g., for datepicker/icons)
                            else if (input.closest('.input-group').length) {
                                input.closest('.input-group').after('<div class="invalid-feedback d-block">' + errors[field][0] + '</div>');
                            } else {
                                input.after('<div class="invalid-feedback d-block">' + errors[field][0] + '</div>');
                            }
                        }
                    }
                } else {
                    // Other errors
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Failed to save transaction.'
                    });
                }
            }
        });
    });

    // fetch currency rates for agent
    function fetchCurrencyRates1() {
        let dataExchangeApiKey = "{{ config('services.exchange.key') }}";
        let currency = $('#currency_select1').val();
        $.ajax({
            url: `https://v6.exchangerate-api.com/v6/${dataExchangeApiKey}/latest/${currency}`,
            method: 'GET',
            success: function(data) {
                let rate = data.conversion_rates['BDT'];
                currentRate = rate; // save globally

                // Update currency rate display
                $('#currency_rate_info1').text(`(1 ${currency} = ${rate} BDT)`);

                updateCurrencyInfoAndAmount1();
            },
            error: function() {
                console.warn("Failed to fetch currency rates.");
            }
        });
    };

    function updateCurrencyInfoAndAmount1() {
        let amount = parseFloat($('#amount1').val()) || 0;

        if (currentRate === null) {
            $('#amount_bdt1').val('');
            return;
        }

        // Calculate BDT amount
        let bdt = (amount * currentRate).toFixed(2);
        $('#amount_bdt1').val(bdt);
    }

    $('#currency_select1').on('input change', function () {
        fetchCurrencyRates1();
    });

    $('#amount1').on('input change', function () {
        updateCurrencyInfoAndAmount1();
    });


    $(document).on('submit', '#agentTransactionForm', function(e) {
        e.preventDefault();

        var form = $(this);
        var formData = new FormData(this);

        // Clear previous errors
        form.find('.invalid-feedback').text('');
        form.find('.is-invalid').removeClass('is-invalid');

        var $btn = form.find('button[type="submit"]');
        $btn.prop('disabled', true).text('Saving...');

        $.ajax({
            url: '/admin/agent/transaction',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $btn.prop('disabled', false).text('Save Transaction');
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Transaction saved successfully!',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    $('#agentTransactionModal').modal('hide');
                    form[0].reset();
                } else {
                    // Handle other server-side errors (not validation)
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Failed to save transaction.'
                    });
                }
            },
            error: function(xhr) {
                $btn.prop('disabled', false).text('Save Transaction');
                if (xhr.status === 422) {
                    // Validation error
                    let errors = xhr.responseJSON.errors;
                    for (let field in errors) {
                        let input = $('[name="' + field + '"]');

                        if (input.length) {
                            input.addClass('is-invalid');

                            // If it's a select2, place error after the select2 container
                            if (input.hasClass('select2-hidden-accessible')) {
                                let select2Container = input.next('.select2');
                                if (select2Container.length) {
                                    select2Container.after('<div class="invalid-feedback d-block">' + errors[field][0] + '</div>');
                                } else {
                                    // fallback
                                    input.after('<div class="invalid-feedback d-block">' + errors[field][0] + '</div>');
                                }
                            }
                            // If inside an input-group (e.g., for datepicker/icons)
                            else if (input.closest('.input-group').length) {
                                input.closest('.input-group').after('<div class="invalid-feedback d-block">' + errors[field][0] + '</div>');
                            } else {
                                input.after('<div class="invalid-feedback d-block">' + errors[field][0] + '</div>');
                            }
                        }
                    }
                } else {
                    // Other errors
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Failed to save transaction.'
                    });
                }
            }
        });
    });

    $(document).on('input change', 'input, select, textarea', function () {
        $(this).removeClass('is-invalid');
        $(this).siblings('.invalid-feedback').remove(); // if siblings
        $(this).closest('.input-group').next('.invalid-feedback').remove(); // if input group
        $(this).next('.select2').next('.invalid-feedback').remove(); // if select2
    });
</script>
{{-- End::candidate transaction create --}}

{{-- Start::candidate transaction list --}}
<script>
    $(document).on('click', '.view-transaction-btn', function() {
        var candidateId = $(this).data('id');
        var candidateName = $(this).data('name') || '';

        // Set the modal title
        $('#candidateTransactionListModalLabel').text('Related transaction about - ' + candidateName);

        $('#candidateTransactionListModal').modal('show');

        // Destroy previous DataTable if exists
        if ($.fn.DataTable.isDataTable('#candidateTransactionTable')) {
            $('#candidateTransactionTable').DataTable().destroy();
        }

        // Clear table body before loading
        $('#candidateTransactionTable tbody').html('<tr><td colspan=\"8\">Loading...</td></tr>');

        // Fetch data via AJAX and initialize DataTable
        $.ajax({
            url: '/admin/candidates/' + candidateId + '/transactions',
            type: 'GET',
            success: function(response) {
                console.log(response);

                var rows = '';
                if (response.data.length > 0) {
                    $.each(response.data, function(i, t) {
                        rows += '<tr>' +
                            '<td>' + t.id + '</td>' +
                            '<td>' + t.transaction_type + '</td>' +
                            '<td>' + t.transaction_purpose + '</td>' +
                            '<td>' + t.payment_method + '</td>' +
                            '<td>' + t.amount_bdt + '</td>' +
                            '<td>' + t.transaction_note + '</td>' +
                            '<td>' + t.date + '</td>' +
                            '</tr>';
                    });
                } else {
                    rows = '<tr><td colspan=\"8\">No transactions found.</td></tr>';
                }
                $('#candidateTransactionTable tbody').html(rows);

                // Initialize DataTable
                $('#candidateTransactionTable').DataTable({
                    responsive: true,
                    ordering: true,
                    pageLength: 5,
                    lengthMenu: [5, 10, 25, 50],
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Search transactions..."
                    }
                });
            },
            error: function() {
                $('#candidateTransactionTable tbody').html('<tr><td colspan=\"8\">Failed to load data.</td></tr>');
            }
        });
    });

    $(document).on('click', '.view-agent-transaction-btn', function() {
        var candidateId = $(this).data('id');
        var candidateName = $(this).data('name') || '';

        // Set the modal title
        $('#agentTransactionListModalLabel').text('Related transaction about - ' + candidateName);

        $('#agentTransactionListModal').modal('show');

        // Destroy previous DataTable if exists
        if ($.fn.DataTable.isDataTable('#agentTransactionTable')) {
            $('#agentTransactionTable').DataTable().destroy();
        }

        // Clear table body before loading
        $('#agentTransactionTable tbody').html('<tr><td colspan=\"8\">Loading...</td></tr>');

        // Fetch data via AJAX and initialize DataTable
        $.ajax({
            url: '/admin/agent/' + candidateId + '/transactions',
            type: 'GET',
            success: function(response) {
                console.log(response);

                var rows = '';
                if (response.data.length > 0) {
                    $.each(response.data, function(i, t) {
                        rows += '<tr>' +
                            '<td>' + t.id + '</td>' +
                            '<td>' + t.transaction_type + '</td>' +
                            '<td>' + t.payment_method + '</td>' +
                            '<td>' + t.amount_bdt + '</td>' +
                            '<td>' + t.transaction_note + '</td>' +
                            '<td>' + t.date + '</td>' +
                            '</tr>';
                    });
                } else {
                    rows = '<tr><td colspan=\"8\">No transactions found.</td></tr>';
                }
                $('#agentTransactionTable tbody').html(rows);

                // Initialize DataTable
                $('#agentTransactionTable').DataTable({
                    responsive: true,
                    ordering: true,
                    pageLength: 5,
                    lengthMenu: [5, 10, 25, 50],
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Search transactions..."
                    }
                });
            },
            error: function() {
                $('#agentTransactionTable tbody').html('<tr><td colspan=\"8\">Failed to load data.</td></tr>');
            }
        });
    });
</script>
{{-- End::candidate transaction list --}}
@endsection
