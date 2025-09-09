@extends('supper_admin.layouts.app')
@section('title', config('app.name') . ' - Manage Sponsor')

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
                <h3 class="box-title">Manage Sponsor</h3>
                <h6 class="box-subtitle">This is all Manage Sponsor List</h6>
            </div>
            <button type="button" class="btn btn-warning addBlogButton" data-toggle="modal" data-target="#modal-center">
                <i class="fa-solid fa-plus"></i> Add Data
            </button>
        </div>

        @include('supper_admin.components.sponsor.sponsor_modal')
        @include('supper_admin.components.sponsor.view_profile_modal')
        @include('supper_admin.components.sponsor.make_transaction_modal')
        @include('supper_admin.components.sponsor.transaction_details_modal')

        <div class="box-body">
            <div class="table-responsive">
                <table id="customDataTable" style="table-layout: fixed; width: 100%;"
                       class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
                    <thead>
                    <tr>
                        <th style="">Action</th>
                        <th style="">DB:ID</th>
                        <th style="">User Type</th>
                        <th style="">User Info</th>
                        <th style="">Sponsor Name</th>
                        <th style="">NID</th>
                        <th style="">Phone</th>
                        <th style="">Balance</th>
                        <th style="">Opening Balance</th>
                        <th style="">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sponsors as $key =>$bonus)
                        <tr>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-bars"></i> Action
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="#" class="dropdown-item viewProfileButton" data-toggle="modal"
                                           data-target="#view_profile" data-id="{{ $bonus->id }}">
                                            <i class="mdi mdi-account-star"></i> View Profile
                                        </a>
                                        <a href="#" class="dropdown-item viewTransactionButton" data-toggle="modal"
                                           data-target="#transaction-details" data-id="{{ $bonus->id }}">
                                            <i class="ti-list"></i> View Transaction
                                        </a>
                                        <a href="#" class="dropdown-item transactionButton" data-toggle="modal"
                                           data-target="#make-transaction" data-id="{{ $bonus->id }}">
                                            <i class="ti-list"></i> Make Transaction
                                        </a>

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
                            <td class="wrap-text">{{ $bonus->sponsor_type  }}</td>
                            @if($bonus->sponsor_type == 'Agent')
                                <td class="wrap-text">{{$bonus->agent ? $bonus->agent->first_name : '' }} {{$bonus->agent ? $bonus->agent->last_name : '' }}</td>
                            @elseif($bonus->sponsor_type == 'Delegate')
                                <td class="wrap-text">{{$bonus->delegate ? $bonus->delegate->first_name : '' }} {{$bonus->delegate ? $bonus->delegate->last_name : '' }}</td>
                            @endif
                            <td class="wrap-text"> <a href="#" class="viewProfileButton" data-toggle="modal"
                                                      data-target="#view_profile" data-id="{{ $bonus->id }}">{{ $bonus->sponsor_name  }}</a></td>
                            <td class="wrap-text">{{ $bonus->nid  }}</td>
                            <td class="wrap-text">{{ $bonus->cell_number  }}</td>
                            <td class="wrap-text">{{ $bonus->balance  }}</td>
                            <td class="wrap-text">{{ $bonus->opening_balance  }}</td>
                            <td>
                            <span class="badge {{ $bonus->status == 'Enabled' ? 'badge-success' : 'badge-danger' }}">
                                {{ $bonus->status == 'Enabled' ? 'Enabled' : 'Disabled' }}
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
            function previewImage(event) {
                const input = event.target;
                const preview = document.getElementById('preview');
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function fetchSponsors() {
                $.ajax({
                    url: '{{ route("supper_admin.sponsors.index") }}',
                    type: 'GET',
                    success: function (data) {
                        let newBody = $(data).find('#customDataTable tbody').html();
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

                fetchAgents();

                function fetchAgents() {
                    $.ajax({
                        url: "{{ route('admin.agent.active') }}",
                        method: "GET",
                        success: function (data) {
                            let select = $('#agentSelect');
                            select.empty();
                            select.append('<option value="" disabled selected>Choose Agent</option>');

                            data.forEach(function (agent) {
                                select.append(
                                    '<option value="' + agent.id + '">' +
                                    agent.first_name + ' - ' + agent.last_name +
                                    '</option>'
                                );
                            });
                        },
                        error: function (xhr) {
                            console.error("Failed to fetch agents:", xhr);
                        }
                    });
                }

                fetchDelegates();

                function fetchDelegates() {
                    $.ajax({
                        url: "{{ route('admin.delegate.active') }}",
                        method: "GET",
                        success: function (data) {
                            let select = $('#delegateSelect');
                            select.empty();
                            select.append('<option value="" disabled selected>Choose Delegate</option>');

                            data.forEach(function (delegate) {
                                select.append(
                                    '<option value="' + delegate.id + '">' +
                                    delegate.first_name + ' - ' + delegate.last_name +
                                    '</option>'
                                );
                            });
                        },
                        error: function (xhr) {
                            console.error("Failed to fetch delegates:", xhr);
                        }
                    });
                }

                // Fetch Countries based on Continent
                function fetchDelegateOffices(delegateId, selectDelegateOfficeId) {
                    $.ajax({
                        url: "{{ route('admin.delegate-office.active') }}",
                        method: "GET",
                        data: {delegate_id: delegateId}, // Pass delegate_id to filter delegate offices
                        success: function (data) {
                            let select = $('#delegateOfficeSelect');
                            select.empty();
                            select.append('<option value="" disabled selected>Delegate Office</option>');
                            data.forEach(function (office) {
                                let selected = office.id === selectDelegateOfficeId ? 'selected' : '';
                                select.append('<option value="' + office.id + '" ' + selected + '>' +
                                    office.office_name +
                                    '</option>');
                            });

                            // Ensure the item dropdown value is updated after population
                            select.val(selectDelegateOfficeId).trigger('change');  // Set selected delegate office
                        },
                        error: function (xhr) {
                            console.error("Failed to fetch delegate offices:", xhr);
                        }
                    });
                }

                fetchCandidates();

                function fetchCandidates() {
                    $.ajax({
                        url: "{{ route('admin.candidate.active') }}",
                        method: "GET",
                        success: function (data) {
                            let select = $('#candidateSelect');
                            select.empty();
                            select.append('<option value="" disabled selected>Candidate</option>');

                            data.forEach(function (candidate) {
                                select.append(
                                    '<option value="' + candidate.id + '">' +
                                    candidate.personal_info.first_name + ' - ' + candidate.personal_info.last_name +' ( ' + candidate.candidate_type.name +' ) ' +
                                    '</option>'
                                );
                            });
                        },
                        error: function (xhr) {
                            console.error("Failed to fetch candidates:", xhr);
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
                            $('#amount_currency').text("(" + currency + ")");

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
                        $('#bdt_amount').val('');
                        return;
                    }

                    // Calculate BDT amount
                    let bdt = (amount * currentRate).toFixed(2);
                    $('#bdt_amount').val(bdt);
                }

                $('#currency_select').on('input change', function () {
                    fetchCurrencyRates();
                });

                $('#amount').on('input change', function () {
                    updateCurrencyInfoAndAmount();
                });

                // English Number to Words
                function numberToEnglishWords(num) {
                    const a = [
                        '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine',
                        'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen',
                        'sixteen', 'seventeen', 'eighteen', 'nineteen'
                    ];
                    const b = [
                        '', '', 'twenty', 'thirty', 'forty', 'fifty',
                        'sixty', 'seventy', 'eighty', 'ninety'
                    ];

                    function convert(n) {
                        if (n < 20) return a[n];
                        if (n < 100) return b[Math.floor(n / 10)] + (n % 10 ? " " + a[n % 10] : "");
                        if (n < 1000) return a[Math.floor(n / 100)] + " hundred" + (n % 100 ? " " + convert(n % 100) : "");
                        if (n < 1000000) return convert(Math.floor(n / 1000)) + " thousand" + (n % 1000 ? " " + convert(n % 1000) : "");
                        return "amount too large";
                    }

                    return convert(num) + " taka only";
                }

                // Bangla Number to Words
                function numberToBanglaWords(num) {
                    const numbers = {
                        0: 'শূন্য',
                        1: 'এক',
                        2: 'দুই',
                        3: 'তিন',
                        4: 'চার',
                        5: 'পাঁচ',
                        6: 'ছয়',
                        7: 'সাত',
                        8: 'আট',
                        9: 'নয়',
                        10: 'দশ',
                        11: 'এগারো',
                        12: 'বারো',
                        13: 'তেরো',
                        14: 'চৌদ্দ',
                        15: 'পনেরো',
                        16: 'ষোল',
                        17: 'সতেরো',
                        18: 'আঠারো',
                        19: 'উনিশ',
                        20: 'বিশ',
                        21: 'একুশ',
                        22: 'বাইশ',
                        23: 'তেইশ',
                        24: 'চব্বিশ',
                        25: 'পঁচিশ',
                        26: 'ছাব্বিশ',
                        27: 'সাতাশ',
                        28: 'আটাশ',
                        29: 'ঊনত্রিশ',
                        30: 'ত্রিশ',
                        31: 'একত্রিশ',
                        32: 'বত্রিশ',
                        33: 'তেত্রিশ',
                        34: 'চৌত্রিশ',
                        35: 'পঁইত্রিশ',
                        36: 'ছত্রিশ',
                        37: 'সাঁইত্রিশ',
                        38: 'আটত্রিশ',
                        39: 'ঊনচল্লিশ',
                        40: 'চল্লিশ',
                        41: 'একচল্লিশ',
                        42: 'বিয়াল্লিশ',
                        43: 'তেতাল্লিশ',
                        44: 'চুয়াল্লিশ',
                        45: 'পঁয়তাল্লিশ ',
                        46: 'ছিচল্লিশ',
                        47: 'সাতচল্লিশ',
                        48: 'আটচল্লিশ',
                        49: 'ঊনপঞ্চাশ',
                        50: 'পঞ্চাশ',
                        51: 'একান্ন',
                        52: 'বাহান্ন',
                        53: 'তিপ্পান্ন',
                        54: 'চুয়ান্ন',
                        55: 'পঁচান্ন',
                        56: 'ছাপ্পান্ন',
                        57: 'সাতান্ন',
                        58: 'আটান্ন',
                        59: 'ঊনষাট',
                        60: 'ষাট',
                        61: 'একষট্টি',
                        62: 'বাষট্টি',
                        63: 'তেষট্টি',
                        64: 'চৌষট্টি',
                        65: 'পঁইষট্টি',
                        66: 'ছেষট্টি',
                        67: 'সাতষট্টি',
                        68: 'আটষট্টি',
                        69: 'ঊনসত্তর',
                        70: 'সত্তর',
                        71: 'একাত্তর',
                        72: 'বাহাত্তর',
                        73: 'তিয়াত্তর',
                        74: 'চুয়াত্তর',
                        75: 'পঁচাত্তর',
                        76: 'ছিয়াত্তর',
                        77: 'সাতাত্তর',
                        78: 'আটাত্তর',
                        79: 'ঊনআশি',
                        80: 'আশি',
                        81: 'একাশি',
                        82: 'বিরাশি',
                        83: 'তিরাশি',
                        84: 'চুরাশি',
                        85: 'পঁচাশি',
                        86: 'ছিয়াশি',
                        87: 'সাতাশি',
                        88: 'আটাশি',
                        89: 'ঊননব্বই',
                        90: 'নব্বই',
                        91: 'একানব্বই',
                        92: 'বিরানব্বই',
                        93: 'তিরানব্বই',
                        94: 'চুরানব্বই',
                        95: 'পঁচানব্বই',
                        96: 'ছিয়ানব্বই',
                        97: 'সাতানব্বই',
                        98: 'আটানব্বই',
                        99: 'নিরানব্বই'
                    };

                    function convert(n) {
                        if (n <= 99) {
                            return numbers[n] || '';
                        } else if (n < 1000) {
                            const hundred = Math.floor(n / 100);
                            const rest = n % 100;
                            return numbers[hundred] + ' শত' + (rest > 0 ? ' ' + convert(rest) : '');
                        } else if (n < 100000) {
                            const thousand = Math.floor(n / 1000);
                            const rest = n % 1000;
                            return convert(thousand) + ' হাজার' + (rest > 0 ? ' ' + convert(rest) : '');
                        } else if (n < 10000000) {
                            const lakh = Math.floor(n / 100000);
                            const rest = n % 100000;
                            return convert(lakh) + ' লক্ষ' + (rest > 0 ? ' ' + convert(rest) : '');
                        }
                        return 'অতিরিক্ত পরিমাণ';
                    }

                    return convert(num) + ' টাকা মাত্র';
                }

                $('#currency_select').on('change', function () {
                    $('#amount').off('keyup').on('keyup', function () {
                        var amount = parseFloat($('#amount').val()) || 0;

                        const bangla = numberToBanglaWords(amount);
                        const english = numberToEnglishWords(amount);

                        $('#amount_translate').html(
                            '<b style="color: #7b7a7a;">' + bangla + '<hr style="margin: 0px;">' +
                            '<span style="text-transform: capitalize;font-size: 9px;">' + english + '</span>' +
                            '</b>'
                        );
                    });
                });

                // Trigger the fetchDelegateOffices function when a delegate is selected
                $('#delegateSelect').on('change', function () {
                    const delegateId = $(this).val();
                    if (delegateId) {
                        fetchDelegateOffices(delegateId);  // Fetch delegate office based on the selected delegate
                    } else {
                        $('#delegateOfficeSelect').empty().append('<option value="" disabled selected>Delegate Office</option>');
                    }
                });

                $('#sponsor_type').on('change', function () {
                    const selectedText = $(this).find('option:selected').text();

                    if (selectedText === 'Agent') {
                        $('#agentDiv').show();
                        $('#delegateDiv').hide();
                        $('#delegateOfficeDiv').hide();
                        $('#openingBalanceDiv').hide();
                    } else if (selectedText === 'Delegate') {
                        $('#delegateDiv').show();
                        $('#delegateOfficeDiv').show();
                        $('#agentDiv').hide();
                        $('#openingBalanceDiv').hide();
                    } else if (selectedText === 'Prime Sponsor') {
                        $('#agentDiv').hide();
                        $('#delegateDiv').hide();
                        $('#delegateOfficeDiv').hide();
                        $('#openingBalanceDiv').show();
                    } else {
                        $('#agentDiv').hide();
                        $('#delegateDiv').hide();
                        $('#delegateOfficeDiv').hide();
                        $('#openingBalanceDiv').hide();
                    }
                });

                $('#sponsorForm').on('submit', function (e) {
                    e.preventDefault();
                    let isEdit = $('#sponsor_id').val() !== '';
                    let formData = new FormData(this);
                    let id = $('#sponsor_id').val();
                    formData.set('status', $('#status').is(':checked') ? 'Enabled' : 'Disabled');
                    const baseUpdateUrl = "{{ url('supper_admin/sponsors') }}";

                    let url = isEdit
                        ? `${baseUpdateUrl}/${id}`
                        : `{{ route('supper_admin.sponsors.store') }}`;

                    let method = isEdit ? 'POST' : 'POST';
                    if (isEdit) {
                        formData.append('_method', 'PUT');
                    }

                    Swal.fire({
                        title: isEdit ? "Update Sponsor?" : "Add Sponsor?",
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
                                        $('#sponsorForm')[0].reset();
                                        $('#sponsor_id').val('');
                                        fetchSponsors();
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function () {
                                    Swal.fire('Error!', 'Failed to save sponsor.', 'error');
                                }
                            });
                        }
                    });
                });

                $('#transactionForm').on('submit', function (e) {
                    e.preventDefault();
                    let formData = new FormData(this);

                    let url =`{{ route('supper_admin.sponsor.make-transaction') }}`;

                    let method = 'POST';

                    Swal.fire({
                        title: "Make Transaction?",
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
                                        $('#make-transaction').modal('hide');
                                        Swal.fire('Success!', response.message, 'success');
                                        $('#transactionForm')[0].reset();
                                        fetchSponsors();
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function () {
                                    Swal.fire('Error!', 'Failed to make transaction.', 'error');
                                }
                            });
                        }
                    });
                });

                $(document).on('click', '.addBlogButton', function () {
                    $('#sponsorForm')[0].reset();
                    $('#sponsor_id').val('');
                    $('#sponsor_type').val('').trigger('change');
                    $('#agentSelect').val('').trigger('change');
                    $('#delegateSelect').val('').trigger('change');
                    $('#delegateOfficeSelect').empty().append('<option value="" disabled selected>Delegate Office</option>');
                    $('#preview').attr('src', '').hide();
                    $('#modalTitle').text('Manage Sponsor');
                    $('#modal-center').modal('show');

                });

                const storageBaseUrl = "{{ asset('') }}";

                $(document).on('click', '.transactionButton', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("supper_admin.sponsors.edit", ":id") }}'.replace(':id', id);
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (res) {
                            $('#modalTitle').text('Make Transaction');
                            $('#sponsor').val(id);
                            $('#sponsor_name1').text(res.sponsor_name);
                            $('#cell_number1').text(res.cell_number);
                            $('#email1').text(res.email);
                            $('#address1').text(res.address);
                            if (res.sponsor_photo) {
                                $('#preview1').attr('src', storageBaseUrl + res.sponsor_photo);
                                $('#preview1').show();
                            } else {
                                console.log('No image path found');  // Log if no image is found
                                $('#preview1').attr('src', '');
                                $('#preview1').hide();
                            }
                            $('#transactionForm')[0].reset();
                            $('#transaction_type').val('').trigger('change');
                            $('#currencySelect').val('').trigger('change');
                            $('#candidateSelect').val('').trigger('change');
                            $('#make-transaction').modal('show');
                        },
                        error: function () {
                            Swal.fire('Error', 'Could not load sponsor data.', 'error');
                        }
                    });

                });

                $(document).on('click', '.editBlogButton', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("supper_admin.sponsors.edit", ":id") }}'.replace(':id', id);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (res) {
                            $('#sponsor_id').val(id);
                            $('#sponsor_type').val(res.sponsor_type).trigger('change');
                            $('#sponsor_name').val(res.sponsor_name);
                            $('#cell_number').val(res.cell_number);
                            $('#opening_balance').val(res.opening_balance);
                            $('#email').val(res.email);
                            $('#nid').val(res.nid);
                            if (res.sponsor_photo) {
                                $('#preview').attr('src', storageBaseUrl + res.sponsor_photo);
                                $('#preview').show();
                                $('#remove-file-section').removeClass('d-none');
                            } else {
                                console.log('No image path found');  // Log if no image is found
                                $('#preview').attr('src', '');
                                $('#preview').hide();
                                $('#remove-file-section').addClass('d-none');
                                $('#remove_file').prop('checked', false);
                            }
                            $('#status').prop('checked', res.status === 'Enabled');
                            $('#modalTitle').text('Edit Sponsor');
                            $('#modal-center').modal('show');
                            $('#agentSelect').val(res.agent_id).trigger('change');
                            $('#delegateSelect').val(res.delegate_id).trigger('change');
                            $('#delegateOfficeSelect').val(res.delegate_office_id).trigger('change');
                            fetchDelegateOffices(res.delegate_id, res.delegate_office_id);
                        },
                        error: function () {
                            Swal.fire('Error', 'Could not load sponsor data.', 'error');
                        }
                    });
                });

                $(document).on('click', '.viewProfileButton', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("supper_admin.sponsors.edit", ":id") }}'.replace(':id', id);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (res) {
                            $('#profile_user_name').text(res.user.name);
                            const date = new Date(res.created_at);
                            const formattedDate = date.toISOString().split('T')[0]; // YYYY-MM-DD

                            const formattedRegistrationDay = date
                                    .toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })
                                    .replace(/(\d+)(?=,)/, (_, d) => d + (["th","st","nd","rd"][(d%10>3||Math.floor(d%100/10)==1)?0:d%10]) + ' of')
                                + ` (${formattedDate})`;
                            $('#sponsor_registration_date').text(formattedRegistrationDay);
                            $('#profile_sponsor').text(res.sponsor_name);
                            $('#profile_sponsor1').text(res.sponsor_name);
                            $('#profile_phone').text(res.cell_number);
                            $('#profile_email').text(res.email);
                            $('#profile_address').text(res.address);
                            if (res.sponsor_photo) {
                                $('#profile_preview').attr('src', storageBaseUrl + res.sponsor_photo);
                                $('#profile_preview').show();
                            } else {
                                console.log('No image path found');  // Log if no image is found
                                $('#profile_preview').attr('src', '');
                                $('#profile_preview').hide();
                            }
                            $('#modalTitle').text('View Profile');
                            $('#view_profile').modal('show');
                        },
                        error: function () {
                            Swal.fire('Error', 'Could not load sponsor profile data.', 'error');
                        }
                    });
                });

                $(document).on('click', '.viewTransactionButton', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("supper_admin.sponsors.edit", ":id") }}'.replace(':id', id);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (res) {
                            if (res.sponsor_type === 'Agent') {
                                $('#sponsor_name_transaction').text(res.agent.first_name + ' '+ res.agent.last_name);
                                $('#sponsor_name_transaction1').text(res.agent.first_name + ' '+ res.agent.last_name);
                            } else if(res.sponsor_type === 'Delegate') {
                                $('#sponsor_name_transaction').text(res.delegate.first_name + ' '+ res.delegate.last_name);
                                $('#sponsor_name_transaction1').text(res.delegate.first_name + ' '+ res.delegate.last_name);
                            } else {
                                $('#sponsor_name_transaction').text(res.sponsor_name);
                                $('#sponsor_name_transaction1').text(res.sponsor_name);
                            }
                            $('#cell_number_transaction').text(res.cell_number);
                            $('#email_transaction').text(res.email);
                            $('#address_transaction').text(res.address);
                            if (res.sponsor_photo) {
                                $('#previewTransaction').attr('src', storageBaseUrl + res.sponsor_photo);
                                $('#previewTransaction').show();
                            } else {
                                console.log('No image path found');  // Log if no image is found
                                $('#previewTransaction').attr('src', '');
                                $('#previewTransaction').hide();
                            }
                            let leaveDatesHtml = '';

                            res.sponsor_transactions.forEach(function (transaction) {
                                let formattedDate = moment(transaction.created_at).format('YYYY-MM-DD');

                                let received = transaction.transaction_type === 'Received Payment' ? transaction.bdt_amount : '0.00';
                                let given = transaction.transaction_type === 'Give Payment' ? transaction.bdt_amount : '0.00';

                                leaveDatesHtml += `<tr>
            <td>${transaction.id}</td>
            <td>${formattedDate}</td>
            <td>${res.sponsor_name}</td>
            <td>0.00</td>
            <td>${received}</td>
            <td>${given}</td>
            <td>0.00</td>
            <td>${transaction.transaction_note}</td>
        </tr>`;
                            });

                            $('#transaction_data_list').html(leaveDatesHtml);
                            $('#transaction-details').modal('show');
                        },
                        error: function () {
                            Swal.fire('Error', 'Could not load sponsor transaction data.', 'error');
                        }
                    });
                });

                $(document).on('click', '.deleteBonusBtn', function () {
                    const id = $(this).data('id');
                    const url = '{{ route("supper_admin.sponsors.destroy", ":id") }}'.replace(':id', id);

                    Swal.fire({
                        title: 'Delete Sponsor?',
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
                                        fetchSponsors();
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function () {
                                    Swal.fire('Error!', 'Failed to delete the sponsor.', 'error');
                                }
                            });
                        }
                    });
                });
            });
        </script>

    @endsection
@endsection
