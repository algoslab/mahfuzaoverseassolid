@extends('supper_admin.layouts.app')
@section('title', config('app.name') . ' - Marketing Visa')

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
                <h3 class="box-title">Marketing Visa</h3>
                <h6 class="box-subtitle">This is all Marketing Visa List</h6>
            </div>
            <button type="button" class="btn btn-warning addBlogButton" data-toggle="modal" data-target="#modal-center">
                <i class="fa-solid fa-plus"></i> Add Data
            </button>
        </div>

        @include('supper_admin.components.sponsor.marketing_visa_modal')

        <div class="box-body">
            <div class="table-responsive">
                <table id="customDataTable" style="table-layout: fixed; width: 100%;"
                       class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                    <thead>
                    <tr>
                        <th style="">Action</th>
                        <th style="">DB:ID</th>
                        <th style="">Country</th>
                        <th style="">Occupation</th>
                        <th style="">Gender</th>
                        <th style="">Cost</th>
                        <th style="">Salary</th>
                        <th style="">Quantity</th>
                        <th style="">Date</th>
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
                           <td class="wrap-text">{{ $bonus->country ? $bonus->country->name : '' }}</td>
                            <td class="wrap-text">{{ $bonus->jobList ? $bonus->jobList->name : '' }}</td>
                            <td class="wrap-text">{{ $bonus->gender  }}</td>
                            <td class="wrap-text">{{ $bonus->cost  }} {{ $bonus->costCurrency ? $bonus->costCurrency->name : '' }}</td>
                            <td class="wrap-text">{{ $bonus->monthly_salary  }} {{ $bonus->salaryCurrency ? $bonus->salaryCurrency->name : '' }}</td>
                            <td class="wrap-text">{{ $bonus->available_qty  }}</td>
                            <td class="wrap-text">{{ $bonus->created_at  }}</td>
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
                    url: '{{ route("supper_admin.marketing-visas.index") }}',
                    type: 'GET',
                    success: function (data) {
                        let newBody = $(data).find('table tbody').html();
                        $('#customDataTable tbody').html(newBody);
                    },
                    error: function () {
                        console.error('Failed to refresh marketing visa table.');
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
                                    '<option value="' + job.id + '">' +
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

                fetchCountries();
                function fetchCountries() {
                    $.ajax({
                        url: "{{ route('admin.country.active') }}",
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

                fetchSalaryCurrencies();

                function fetchSalaryCurrencies() {
                    $.ajax({
                        url: "{{ route('supper_admin.currency.active') }}",
                        method: "GET",
                        success: function (data) {
                            let select = $('#salaryCurrencySelect');
                            select.empty();
                            select.append('<option value="" disabled selected>Choose Currency</option>');
                            data.forEach(function (currency) {
                                select.append(
                                    '<option value="' + currency.id + '">' +
                                    currency.name + '</option>'
                                );
                            });

                        },
                        error: function (xhr) {
                            console.error("Failed to fetch currencies:", xhr);
                        }
                    });
                }

                fetchCostCurrencies();

                function fetchCostCurrencies() {
                    $.ajax({
                        url: "{{ route('supper_admin.currency.active') }}",
                        method: "GET",
                        success: function (data) {
                            let select = $('#costCurrencySelect');
                            select.empty();
                            select.append('<option value="" disabled selected>Choose Currency</option>');
                            data.forEach(function (currency) {
                                select.append(
                                    '<option value="' + currency.id + '">' +
                                    currency.name + '</option>'
                                );
                            });

                        },
                        error: function (xhr) {
                            console.error("Failed to fetch currencies:", xhr);
                        }
                    });
                }


                $('#visaForm').on('submit', function (e) {
                    e.preventDefault();
                    let isEdit = $('#marketing_visa_id').val() !== '';
                    let formData = new FormData(this);
                    let id = $('#marketing_visa_id').val();
                    formData.set('send_sms_to_agent', $('#send_sms_to_agent').is(':checked') ? '1' : '0');
                    formData.set('status', $('#status').is(':checked') ? 'Enabled' : 'Disabled');
                    const baseUpdateUrl = "{{ url('supper_admin/marketing-visas') }}";
                    let url = isEdit
                        ? `${baseUpdateUrl}/${id}`
                        : `{{ route('supper_admin.marketing-visas.store') }}`;

                    let method = isEdit ? 'POST' : 'POST';
                    if (isEdit) {
                        formData.append('_method', 'PUT');
                    }

                    Swal.fire({
                        title: isEdit ? "Update Marketing Visa?" : "Add Marketing Visa?",
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
                                        $('#marketing_visa_id').val('');
                                        fetchVisas();
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function () {
                                    Swal.fire('Error!', 'Failed to save marketin visa.', 'error');
                                }
                            });
                        }
                    });
                });

                $(document).on('click', '.addBlogButton', function () {
                    $('#visaForm')[0].reset();
                    $('#marketing_visa_id').val('');
                    $('#countrySelect').val('').trigger('change');
                    $('#jobSelect').val('').trigger('change');
                    $('#costCurrencySelect').val('').trigger('change');
                    $('#salaryCurrencySelect').val('').trigger('change');
                    $('#modalTitle').text('Marketing Visa');
                    $('#modal-center').modal('show');

                });

                $(document).on('click', '.editBlogButton', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("supper_admin.marketing-visas.edit", ":id") }}'.replace(':id', id);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (res) {
                            $('#marketing_visa_id').val(id);
                            $('#jobSelect').val(res.job_list_id).trigger('change');
                            $('#countrySelect').val(res.country_id).trigger('change');
                            $('#salaryCurrencySelect').val(res.salary_currency_id).trigger('change');
                            $('#costCurrencySelect').val(res.cost_currency_id).trigger('change');
                            $('#type').val(res.type);
                            $('#gender').val(res.gender);
                            $('#monthly_salary').val(res.monthly_salary);
                            $('#cost').val(res.cost);
                            $('#available_qty').val(res.available_qty);
                            $('#registration_fee').val(res.registration_fee);
                            $('#note').val(res.note);

                            // Show existing file
                            if (res.attachment) {
                                const filePath = res.attachment; // example: expense_categories/filename.pdf
                                const ext = filePath.split('.').pop().toLowerCase();

                                // Prepend Laravel's public storage path
                                const fileUrl = `/storage/${filePath}`;

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
                                $('#remove_file').prop('checked', false);
                            }
                            $('#send_sms_to_agent').prop('checked', res.send_sms_to_agent == '1');
                            $('#status').prop('checked', res.status === 'Enabled');
                            $('#modalTitle').text('Edit Marketing Visa');
                            $('#modal-center').modal('show');
                        },
                        error: function () {
                            Swal.fire('Error', 'Could not load marketing visa data.', 'error');
                        }
                    });
                });

                $(document).on('click', '.deleteBonusBtn', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("supper_admin.marketing-visas.destroy", ":id") }}'.replace(':id', id);

                    Swal.fire({
                        title: 'Delete Marketing Visa?',
                        text: "This action cannot be undone.",
                        icon: 'warning',                        showCancelButton: true,
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
                                    Swal.fire('Error!', 'Failed to delete the marketing visa.', 'error');
                                }
                            });
                        }
                    });
                });
            });
        </script>

    @endsection
@endsection
