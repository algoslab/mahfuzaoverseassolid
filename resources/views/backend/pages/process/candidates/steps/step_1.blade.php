<div class="row form-group col-md-3">
    <label for="candidate_type_id" class="font-weight-bold text-dark" style="font-size: 14px;">Candidate Type</label>
    <select id="candidate_type_id" class="form-control select2" disabled>
        <option value="">--Select One--</option>
        @foreach($candidateTypes as $id => $name)
            <option value="{{ $id }}" 
                {{ session('form.step_1.candidate_type_id') == $id ? 'selected' : '' }}>
                {{ $name }}
            </option>
        @endforeach
    </select>

    <!-- Hidden input for validation -->
    <input type="hidden" name="candidate_type_id" id="candidate_type_id_hidden" value="{{ session('form.step_1.candidate_type_id') }}">
</div>


<div class="row">
    <div class="form-group col-md-3">
        <label for="referral_agent_id" class="font-weight-bold text-dark" style="font-size: 14px;">Referral Agent</label>
        <select id="referral_agent_id" name="referral_agent_id" class="form-control select2">
            <option value="">--Select One--</option>
            @foreach($agents as $id => $name)
                <option value="{{ $id }}" 
                    {{ session('form.step_1.referral_agent_id') == $id ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-3">
        <label for="interested_country_id" class="font-weight-bold text-dark" style="font-size: 14px;">Interested Country</label>
        <select id="interested_country_id" name="interested_country_id" class="form-control select2">
            <option value="">--Select One--</option>
            @foreach($countries as $id => $name)
                <option value="{{ $id }}" 
                    {{ session('form.step_1.interested_country_id') == $id ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-3">
        <label for="interested_profession_id" class="font-weight-bold text-dark" style="font-size: 14px;">Interested Profession</label>
        <select id="interested_profession_id" name="interested_profession_id" class="form-control select2">
            <option value="">--Select One--</option>
            @foreach($professions as $id => $name)
                <option value="{{ $id }}" 
                    {{ session('form.step_1.interested_profession_id') == $id ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-3">
        <label for="nationality" class="font-weight-bold text-dark" style="font-size: 14px;">Nationality</label>
        <input type="text" id="nationality" name="nationality" class="form-control" value="{{ session('form.step_1.nationality') ?? 'Bangladeshi' }}">
    </div>

    <!-- Agent Info Display Area (below Interested Country) -->
    <div class="form-group col-md-3 mt-0">
        <div id="agent_info"></div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function() {
    function updateFields(candidateTypeId) {
        if(candidateTypeId) {
            $.ajax({
                url: '/admin/fields-status/' + candidateTypeId,
                type: 'GET',
                success: function(fields) {
                    for (const [fieldId, isEnabled] of Object.entries(fields)) {
                        let input = $('#' + fieldId);
                        if (input.length) {
                            input.prop('disabled', isEnabled == 0);
                            if(input.hasClass('select2-hidden-accessible')) {
                                input.trigger('change.select2');
                            }
                            if(isEnabled == 0) input.val(null).trigger('change');
                        }
                    }
                },
                error: function() {
                    console.log('Unable to fetch fields status');
                }
            });
        }
    }

    // Pre-selected candidate type on page load
    let preSelected = $('#candidate_type_id').val();
    let $hiddenInput = $('#candidate_type_id_hidden');
    if(preSelected){
        // disable the dropdown
        $('#candidate_type_id').prop('disabled', true);
        // set hidden input for validation
        $hiddenInput.val(preSelected);
        // update fields
        updateFields(preSelected);
    }

    // When candidate type changes via dropdown (optional)
    $('#candidate_type_id').on('change', function() {
        let candidateTypeId = $(this).val();
        updateFields(candidateTypeId);
        $hiddenInput.val(candidateTypeId);
    });
});



</script>









