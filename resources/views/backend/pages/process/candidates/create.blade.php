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
    .candidate-type-item {
        padding: 10px 12px;
        border-radius: 5px;
        color: #6c757d;
        font-weight: 500;
        background-color: #ffffff;
        transition: all 0.2s;
    }
    .candidate-type-item:hover {
        background-color: #e2e6ea;
        cursor: pointer;
    }
    .candidate-type-item.active {
        background-color: #0d6efd;
        color: #fff;
        font-weight: 700;
    }
</style>
@endsection

@section('content')
<div class="d-flex">
    <!-- Sidebar -->
    <div class="candidate_type_container" style="width: 250px; background-color: #f5f5f5; padding: 15px; border-right: 1px solid #dee2e6;">
        <h5 class="fw-bold mb-3">Candidate Type</h5>
        <div class="media-list media-list-hover media-list-divided">
            @foreach($candidateTypes as $id => $name)
                <a onclick="selectCandidate('{{ $id }}', '{{ $name }}', this)"
                   class="media media-single d-block mb-2 candidate-type-item"
                   href="javascript:void(0);">
                    <span class="title">{{ $name }}</span>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Right Side -->
    <div class="flex-grow-1 ps-3">
        <div class="box">
            <div class="box-header with-border d-flex justify-content-between align-items-center">
                <h3 class="box-title" id="candidateFormTitle">New Candidate Form</h3>
            </div>
            <div class="box-body" id="content-wrapper">
                @include('backend.pages.process.candidates.partials.form', ['step' => $step])
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
let currentStep = {{ $step }};

// ==================== Candidate select ====================
function selectCandidate(candidateId, candidateName, element) {
    $('.candidate-type-item').removeClass('active');
    $(element).addClass('active');

    $('#candidateFormTitle').text('New ' + candidateName + ' Form');

    // Step 1: auto select dropdown, disable it, update hidden input
    let $candidateSelect = $('#candidate_type_id');
    if($candidateSelect.length) {
        $candidateSelect.val(candidateId).trigger('change'); // set value
        $candidateSelect.prop('disabled', true); // disable immediately
        // update hidden input for validation if needed
        $('#candidate_type_id_hidden').val(candidateId);
    }

    // Trigger field enable/disable logic immediately
    updateFields(candidateId);

    // AJAX load form
    let formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('step', currentStep);
    formData.append('candidate_type_id', candidateId);

    $.ajax({
        url: "{{ route('admin.candidates.store') }}",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(res) {
            if(res.success){
                currentStep = res.step;
                $('#content-wrapper').html(res.html);
                initSelect2(); // re-init select2 for new content
            }
        },
        error: function(xhr){
            console.log('Error loading candidate form:', xhr.responseText);
        }
    });
}




// ==================== Form submit ====================
$(document).on('submit', '#candidateForm', function(e){
    e.preventDefault();
    $('#candidateForm .is-invalid').removeClass('is-invalid');
    $('#candidateForm .invalid-feedback').remove();

    let formData = new FormData(this);
    formData.append('step', currentStep);

    $.ajax({
        url: "{{ route('admin.candidates.store') }}",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(res){
            if(res.success){
                if(res.redirect){
                    window.location.href = res.redirect;
                } else {
                    currentStep = res.step;
                    $('#content-wrapper').html(res.html);
                    initSelect2();
                }
            }
        },
        error: function(xhr){
            if(xhr.status === 422){
                let errors = xhr.responseJSON.errors;
                for(let field in errors){
                    let input = $('[name="'+field+'"]');
                    input.addClass('is-invalid');
                    let errorHtml = '<div class="invalid-feedback d-block">'+errors[field][0]+'</div>';
                    if(input.hasClass('select2-hidden-accessible')){
                        input.next('.select2').after(errorHtml);
                    } else if(input.closest('.input-group').length){
                        input.closest('.input-group').after(errorHtml);
                    } else {
                        input.after(errorHtml);
                    }
                }
            } else {
                alert('Submission failed!');
                console.log(xhr.responseText);
            }
        }
    });
});

// ==================== Previous button ====================
$(document).on('click', '#prevBtn', function(){
    if(currentStep > 1){
        let formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('step', currentStep - 1);
        formData.append('prev', true);

        $.ajax({
            url: "{{ route('admin.candidates.store') }}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(res){
                if(res.success){
                    currentStep = res.step;
                    $('#content-wrapper').html(res.html);
                    initSelect2();
                    if(currentStep == 1){
                        let preSelectedAgentId = $('#referral_agent_id').val();
                        if(preSelectedAgentId){
                            $('#referral_agent_id').trigger('change');
                        }
                    }
                }
            },
            error: function(xhr){
                alert('Something went wrong.');
                console.log(xhr.responseText);
            }
        });
    }
});

// ==================== Select2 init ====================
function initSelect2(){
    $('.select2').select2({ width: '100%' });
}

// ==================== Referral Agent ====================
$(document).on('change', '#referral_agent_id', function(){
    let agentId = $(this).val();
    if(agentId){
        $.ajax({
            url: `/admin/agents/${agentId}`,
            method: 'GET',
            success: function(data){
                $('#agent_info').html(`
                    <div class="card p-3 d-flex flex-row align-items-start" style="gap: 1.5rem;">
                        <div style="flex:0 0 100px;">
                            <img src="${data.agent_photo_url}" alt="Agent Image" class="img-thumbnail rounded-circle" style="width:100px;height:100px;object-fit:cover;">
                        </div>
                        <div style="flex:1;">
                            <table class="table table-sm mb-0">
                                <tbody>
                                    <tr><th class="align-label">Name</th><td>${data.first_name} ${data.last_name}</td></tr>
                                    <tr><th class="align-label">Email</th><td>${data.email}</td></tr>
                                    <tr><th class="align-label">Phone</th><td>${data.phone_number}</td></tr>
                                    <tr><th class="align-label">Country</th><td>${data.country.name}</td></tr>
                                    <tr><th class="align-label">Address</th><td>${data.current_address}</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                `);
            },
            error: function(){
                $('#agent_info').html('<p class="text-danger">Unable to fetch agent info.</p>');
            }
        });
    } else {
        $('#agent_info').html('');
    }
});

// ==================== Enable final submit ====================
$(document).on('change', '#confirmInfoCheckbox', function(){
    $('#finalSubmitBtn').prop('disabled', !this.checked);
});

// ==================== Page load ====================
$(function(){
    initSelect2();
    let preSelectedAgentId = $('#referral_agent_id').val();
    if(preSelectedAgentId){
        $('#referral_agent_id').trigger('change');
    }
});
</script>
@endsection
