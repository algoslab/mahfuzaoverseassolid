@extends('backend.layouts.app')
@section('title', config('app.name') . ' - Candidates')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .select2-container .select2-selection--single {
            height: 32px;
            border: 1px solid #86a4c3;
            border-radius: 5px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 24px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 32px;
            /* right: 0px; */
        }

        .step-nav { display: flex; flex-wrap: wrap; justify-content: space-between; margin-bottom: 30px; }
        .step-item {
            flex: 1;
            text-align: center;
            padding: 10px 5px;
            border-bottom: 3px solid #dee2e6;
            color: #6c757d;
            font-weight: 500;
            font-size: 14px;
        }
        .step-item.active {
            border-color: #0d6efd;
            color: #0d6efd;
            font-weight: 700;
        }
        .align-label {
            text-align: right;
            white-space: nowrap;
        }
        .align-label::after {
            content: ":";
            padding-left: 5px;
        }
    </style>
@endsection

@section('content')
<div class="box">
    <div class="box-header with-border d-flex justify-content-between align-items-center">
        <h3 class="box-title">New Worker Form</h3>
    </div>
    <div class="box-body" id="content-wrapper">
        @include('backend.pages.process.candidates.partials.form', ['step' => $step])
    </div>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    let currentStep = {{ $step }};
    // console.log("Current Step:", currentStep);

    // Handle form submit (Next or Final Submit)
    $(document).on('submit', '#candidateForm', function (e) {        
        e.preventDefault();
        // Remove previous errors
        $('#candidateForm .is-invalid').removeClass('is-invalid');
        $('#candidateForm .invalid-feedback').remove();
        let formData = new FormData(this);
        formData.append('step', currentStep); // always send current step

        $.ajax({
            url: "{{ route('admin.candidates.store') }}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.success) {
                    if (res.redirect) {
                        window.location.href = res.redirect;
                    }else {
                        currentStep = res.step;
                        $('#content-wrapper').html(res.html);
                        initSelect2();
                    }
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;

                    // Remove previous errors
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').remove();

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
                    alert('Submission failed!');
                    console.log(xhr.responseText);
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

    // Handle previous button click
    $(document).on('click', '#prevBtn', function () {
        if (currentStep > 1) {
            let formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('step', currentStep - 1);
            formData.append('prev', true); // flag to indicate previous request

            $.ajax({
                url: "{{ route('admin.candidates.store') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    if (res.success) {
                        currentStep = res.step;
                        $('#content-wrapper').html(res.html);
                        initSelect2();
                        // If step 1, trigger agent info display if agent is selected
                        if (currentStep == 1) {
                            var preSelectedAgentId = $('#referral_agent_id').val();
                            if (preSelectedAgentId) {
                                $('#referral_agent_id').trigger('change');
                            }
                        }
                    }
                },
                error: function (xhr) {
                    alert('Something went wrong.');
                    console.log(xhr.responseText);
                }
            });
        }
    });

    function initSelect2() {
        $('.select2').select2({ width: '100%' });
    }

    $(document).on('change', '#referral_agent_id', function() {
        const agentId = $(this).val();

        if (agentId) {
            $.ajax({
                url: `/admin/agents/${agentId}`,
                method: 'GET',
                success: function(data) {
                    $('#agent_info').html(`
                        <div class="card p-3 d-flex flex-row align-items-start" style="gap: 1.5rem;">
                            <!-- Agent Image -->
                            <div style="flex: 0 0 100px;">
                                <img src="${data.agent_photo_url}" 
                                    alt="Agent Image" 
                                    class="img-thumbnail rounded-circle" 
                                    style="width: 100px; height: 100px; object-fit: cover;">
                            </div>

                            <!-- Agent Info Table -->
                            <div style="flex: 1;">
                                <table class="table table-sm mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="align-label">Name</th>
                                            <td>${data.first_name} ${data.last_name}</td>
                                        </tr>
                                        <tr>
                                            <th class="align-label">Email</th>
                                            <td>${data.email}</td>
                                        </tr>
                                        <tr>
                                            <th class="align-label">Phone</th>
                                            <td>${data.phone_number}</td>
                                        </tr>
                                        <tr>
                                            <th class="align-label">Country</th>
                                            <td>${data.country.name}</td>
                                        </tr>
                                        <tr>
                                            <th class="align-label">Address</th>
                                            <td>${data.current_address}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    `);
                },

                error: function() {
                    $('#agent_info').html('<p class="text-danger">Unable to fetch agent info.</p>');
                }
            });
        } else {
            $('#agent_info').html('');
        }
    });

    // Show agent info if agent is already selected on page load
    $(function() {
        var preSelectedAgentId = $('#referral_agent_id').val();
        if (preSelectedAgentId) {
            $('#referral_agent_id').trigger('change');
        }
    });

    // Enable submit button only if confirmation checkbox is checked (on step 7)
    $(document).on('change', '#confirmInfoCheckbox', function() {
        $('#finalSubmitBtn').prop('disabled', !this.checked);
    });

    // When step 7 is loaded via AJAX, ensure the button is disabled until checked
    $(document).on('change', '#step', function() {
        if ($(this).val() == 7) {
            $('#finalSubmitBtn').prop('disabled', !$('#confirmInfoCheckbox').is(':checked'));
        }
    });
</script>
@endsection
