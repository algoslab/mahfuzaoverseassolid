@extends('backend.layouts.app')
@section('title', config('app.name') . ' - Manage Visa')

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
        <!-- Header Section -->
        <div class="box-header with-border d-flex justify-content-between align-items-center">
            <div>
                <h3 class="box-title">Manage Visa</h3>
                <h6 class="box-subtitle">This is all Manage Visa List</h6>
            </div>
            <button type="button" class="btn btn-warning addBlogButton" data-toggle="modal" data-target="#modal-center">
                <i class="fa-solid fa-plus"></i> Add Data
            </button>
        </div>

        @include('supper_admin.components.sponsor.visa_modal')

        <div class="box-body">
            <div class="table-responsive">
                <table id="customDataTable" style="table-layout: fixed; width: 100%;"
                       class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                    <thead>
                    <tr>
                        <th style="">Action</th>
                        <th style="">DB:ID</th>
                        <th style="">Sponsor Name</th>
                        <th style="">Delegate Name</th>
                        <th style="">Country</th>
                        <th style="">Job</th>
                        <th style="">Gender</th>
                        <th style="">Age</th>
                        <th style="">p:Qty</th>
                        <th style="">A:Qty</th>
                        <th style="">Currency</th>
                        <th style="">Purchase Price</th>
                        <th style="">Due Amount</th>
                        <th style="">Payment</th>
                        <th style="">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($visas as $key =>$bonus)
                        <tr>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bars"></i> Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <!-- Edit Button inside Dropdown -->
                                        <a href="#" class="dropdown-item editBlogButton" data-toggle="modal" data-target="#modal-center" data-id="{{ $bonus->id }}">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>

                                        <!-- Delete Form inside Dropdown -->
                                        <button type="button"
                                                class="dropdown-item text-danger deleteBonusBtn"
                                                data-id="{{ $bonus->id }}">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </td>

                            <td>{{ $key + 1 }}</td>
                            <td class="wrap-text">{{ $bonus->sponsor ? $bonus->sponsor->sponsor_name : '' }}</td>
                            <td class="wrap-text">{{ $bonus->sponsor_type  }}</td>
                        @if(isset($bonus->sponsor) && $bonus->sponsor->sponsor_type == 'Prime Sponsor')
                                <td class="wrap-text">{{$bonus->sponsor ? $bonus->sponsor->sponsor_type : '' }} | {{$bonus->sponsor ? $bonus->sponsor->sponsor_name : ''}}</td>
                            @elseif(isset($bonus->sponsor) && $bonus->sponsor->sponsor_type == 'Delegate')
                                <td class="wrap-text">{{$bonus->sponsor ? $bonus->sponsor->sponsor_type : '' }} | {{$bonus->sponsor->delegate ? $bonus->sponsor->delegate->first_name : '' }} {{$bonus->sponsor->delegate ? $bonus->sponsor->delegate->last_name : '' }}</td>
                            @endif
                            <td class="wrap-text">{{ $bonus->country ? $bonus->country->name : '' }}</td>
                            <td class="wrap-text">{{ $bonus->jobList ? $bonus->jobList->name : '' }}</td>
                            <td class="wrap-text">{{ $bonus->gender  }}</td>
                            <td class="wrap-text">{{ $bonus->age_from  }} - {{ $bonus->age_to  }}</td>
                            <td>0.00</td>
                            <td>{{ $bonus->visa_qty  }}</td>
                            <td class="wrap-text">{{ $bonus->currency }}</td>
                            <td class="wrap-text">{{ $bonus->purchase_amount  }}</td>
                            <td class="wrap-text">0.00</td>
                            <td>
                            <span class="badge {{ $bonus->payment_type == 'Paid' ? 'badge-success' : 'badge-danger' }}">
                                {{ $bonus->payment_type == 'Paid' ? 'Paid' : 'Due' }}
                            </span>
                            </td>
                            <td>
                            <span class="badge {{ $bonus->status == 'Enabled' ? 'badge-success' : 'badge-danger' }}">
                                {{ $bonus->status == 'Enabled' ? 'Enabled' : 'Disabled' }}
                            </span>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
1
            </div>
        </div>
    </div>

    @section('script')
        <script>
            function fetchVisas() {
                $.ajax({
                    url: '{{ route("admin.visas.index") }}',
                    type: 'GET',
                    success: function (data) {
                        let newBody = $(data).find('table tbody').html();
                        $('#customDataTable tbody').html(newBody);
                    },
                    error: function () {
                        console.error('Failed to refresh sponsor table.');
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

                fetchSponsors();

                function fetchSponsors() {
                    $.ajax({
                        url: "{{ route('admin.sponsor.enabled') }}",
                        method: "GET",
                        success: function (data) {
                            let select = $('#sponsorSelect');
                            select.empty();
                            select.append('<option value="" disabled selected>Choose Sponsor</option>');

                            data.forEach(function (sponsor) {
                                select.append(
                                    '<option value="' + sponsor.id + '">' +
                                    sponsor.sponsor_name +
                                '</option>'
                                );
                            });
                        },
                        error: function (xhr) {
                            console.error("Failed to fetch sponsors:", xhr);
                        }
                    });
                }

                fetchJobLists();

                function fetchJobLists() {
                    $.ajax({
                        url: "{{ route('admin.jobLists.active') }}",
                        method: "GET",
                        success: function (data) {
                            let select = $('#jobSelect');
                            select.empty();
                            select.append('<option value="" disabled selected>Choose Job</option>');

                            data.forEach(function (job) {
                                select.append(
                                    '<option data-job_type="' + job.job_type + '" value="' + job.id + '">' +
                                    job.name +
                                    '</option>'
                                );
                            });
                        },
                        error: function (xhr) {
                            console.error("Failed to fetch jobs:", xhr);
                        }
                    });
                }

                fetchcountriess();
                function fetchcountriess() {
                    $.ajax({
                        url: "{{ route('supper_admin.country.active') }}",
                        method: "GET",
                        success: function(data) {
                            let select = $('#countrySelect');
                            select.empty();
                            select.append('<option value="" disabled selected>Country</option>');
                            data.forEach(function(State) {
                                select.append('<option value="' + State.id + '">' + State.name + '</option>');
                            });
                        },
                        error: function(xhr) {
                            console.error("Failed to fetch countries:", xhr);
                        }
                    });
                }

                fetchCurrencies();

                function fetchCurrencies() {
                    $.ajax({
                        url: "{{ route('admin.currency.active') }}",
                        method: "GET",
                        success: function (data) {
                            let select = $('#currencySelect');
                            select.empty();
                            select.append('<option value="" disabled selected>Choose Currency</option>');
                            data.forEach(function (currency) {
                                select.append(
                                    '<option data-bdt_amount="' + currency.bdt_amount + '" data-name="' + currency.name + '" value="' + currency.id + '">' +
                                    currency.name + '</option>'
                                );
                            });

                        },
                        error: function (xhr) {
                            console.error("Failed to fetch currencies:", xhr);
                        }
                    });
                }

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
                    if (currentRate === null) {
                        $('#bdt_price').val('');
                        return;
                    }

                    // Calculate BDT amount
                    let bdt = currentRate.toFixed(2);
                    $('#bdt_price').val(bdt);
                }

                $('#currency_select').on('input change', function () {
                    fetchCurrencyRates();
                });

                $('#amount').on('input change', function () {
                    updateCurrencyInfoAndAmount();
                });


                $('#jobSelect').on('change', function () {
                    const selectedOption = $(this).find('option:selected');
                    const job_type = selectedOption.data('job_type');
                    if(job_type && job_type.toLowerCase() === "commission") {
                        $('#visa_qty').val(0);
                        $('#purchase_div_prev').hide();
                        $('#commission_div').show();
                    } else {
                        $('#visa_qty').val('');
                        $('#purchase_div_prev').show();
                        $('#commission_div').hide();
                    }
                });

                $('#visaForm').on('submit', function (e) {
                    e.preventDefault();
                    let isEdit = $('#visa_id').val() !== '';
                    let formData = new FormData(this);
                    let id = $('#visa_id').val();
                    formData.set('provide_food', $('#provide_food').is(':checked') ? '1' : '0');
                    formData.set('provide_accommodation', $('#provide_accommodation').is(':checked') ? '1' : '0');
                    formData.set('status', $('#status').is(':checked') ? 'Enabled' : 'Disabled');
                    const baseUpdateUrl = "{{ url('admin/visas') }}";
                    let url = isEdit
                        ? `${baseUpdateUrl}/${id}`
                        : `{{ route('admin.visas.store') }}`;

                    let method = isEdit ? 'POST' : 'POST';
                    if (isEdit) {
                        formData.append('_method', 'PUT');
                    }

                    Swal.fire({
                        title: isEdit ? "Update Visa?" : "Add Visa?",
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
                                        $('#visaForm')[0].reset();
                                        $('#visa_id').val('');
                                        fetchVisas();
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function () {
                                    Swal.fire('Error!', 'Failed to save visa.', 'error');
                                }
                            });
                        }
                    });
                });

                $(document).on('click', '.addBlogButton', function () {
                    $('#visaForm')[0].reset();
                    $('#visa_id').val('');
                    $('#currencySelect').val('').trigger('change');
                    $('#modalTitle').text('Manage Visa');
                    $('#modal-center').modal('show');

                });

                $(document).on('click', '.editBlogButton', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("admin.visas.edit", ":id") }}'.replace(':id', id);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (res) {
                            $('#visa_id').val(id);
                            $('#sponsorSelect').val(res.sponsor_id).trigger('change');
                            $('#jobSelect').val(res.job_list_id).trigger('change');
                            $('#countrySelect').val(res.country_id).trigger('change');
                            $('#currency_select').val(res.currency).trigger('change');
                            $('#issue_date').val(res.issue_date);
                            $('#age_from').val(res.age_from);
                            $('#age_to').val(res.age_to);
                            $('#visa_number').val(res.visa_number);
                            $('#visa_qty').val(res.visa_qty);
                            $('#type').val(res.type);
                            $('#gender').val(res.gender);
                            $('#monthly_salary').val(res.monthly_salary);
                            $('#purchase_amount').val(res.purchase_amount);
                            $('#agent_price').val(res.agent_price);
                            $('#candidate_price').val(res.candidate_price);
                            $('#commission_amount').val(res.commission_amount);
                            $('#payment_type').val(res.payment_type);
                            // Show existing file
                            if (res.demand_latter) {
                                const filePath = res.demand_latter; // example: expense_categories/filename.pdf
                                const ext = filePath.split('.').pop().toLowerCase();

                                // Prepend Laravel's public storage path
                                const fileUrl = `/${filePath}`;

                                let previewHtml = '';

                                if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                                    previewHtml = `<img src="${fileUrl}" alt="Uploaded File" class="img-thumbnail" style="max-height: 200px;">`;
                                } else {
                                    previewHtml = `<a href="${fileUrl}" target="_blank" class="btn btn-outline-primary btn-sm">View File</a>`;
                                }

                                $('#existing-file-preview1').html(previewHtml);
                                $('#remove-file-section1').removeClass('d-none');
                            } else {
                                $('#existing-file-preview1').empty();
                                $('#remove-file-section1').addClass('d-none');
                                $('#remove_file1').prop('checked', false);
                            }
                            // Show existing file
                            if (res.attachment) {
                                const filePath = res.attachment; // example: expense_categories/filename.pdf
                                const ext = filePath.split('.').pop().toLowerCase();

                                // Prepend Laravel's public storage path
                                const fileUrl = `/${filePath}`;

                                let previewHtml = '';

                                if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                                    previewHtml = `<img src="${fileUrl}" alt="Uploaded File" class="img-thumbnail" style="max-height: 200px;">`;
                                } else {
                                    previewHtml = `<a href="${fileUrl}" target="_blank" class="btn btn-outline-primary btn-sm">View File</a>`;
                                }

                                $('#existing-file-preview').html(previewHtml);
                                $('#remove-file-section').removeClass('d-none');
                            } else {
                                $('#existing-file-preview').empty();
                                $('#remove-file-section').addClass('d-none');
                                $('#remove_file').prop('checked', false);-0
                            }
                            $('#provide_food').prop('checked', res.provide_food == '1');
                            $('#provide_accommodation').prop('checked', res.provide_accommodation == '1');
                            $('#status').prop('checked', res.status === 'Enabled');
                            $('#modalTitle').text('Edit Visa');
                            $('#modal-center').modal('show');
                        },
                        error: function () {
                            Swal.fire('Error', 'Could not load visa data.', 'error');
                        }
                    });
                });

                $(document).on('click', '.deleteBonusBtn', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("admin.visas.destroy", ":id") }}'.replace(':id', id);

                    Swal.fire({
                        title: 'Delete Visa?',
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
                                        fetchVisas();
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function () {
                                    Swal.fire('Error!', 'Failed to delete the visa.', 'error');
                                }
                            });
                        }
                    });
                });
            });
        </script>

    @endsection
@endsection
