<input type="hidden" id="candidate_type_id_hidden" value="{{ session('form.step_1.candidate_type_id') }}">
<div class="row form-group col-md-3">
    <label for="experience_type" class="font-weight-bold text-dark" style="font-size: 14px;">Experience Type</label>
    <select id="experience_type" name="experience_type" class="form-control select2">
        <option value="">--Select One--</option>
        <option value="fresher" {{ session('form.step_3.experience_type') == 'fresher' ? 'selected' : '' }}>Fresher</option>
        <option value="experienced" {{ session('form.step_3.experience_type') == 'experienced' ? 'selected' : '' }}>Experienced</option>
    </select>
</div>

<div id="experienceFieldsWrapper" style="display: none;">
    <div class="row">
        <div class="form-group col-md-3">
            <label for="company_name" class="font-weight-bold text-dark" style="font-size: 14px;">Company Name</label>
            <input type="text" id="company_name" name="company_name" class="form-control" placeholder="Company Name" value="{{ session('form.step_3.company_name') }}">
        </div>
    
        <div class="form-group col-md-3">
            <label for="work_type_id" class="font-weight-bold text-dark" style="font-size: 14px;">Work Type</label>
            <select id="work_type_id" name="work_type_id" class="form-control select2">
                <option value="">--Select One--</option>
                @foreach ($workTypes as $id => $name)
                    <option value="{{ $id }}" 
                        {{ session('form.step_3.work_type_id') == $id ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
        </div>
    
        <div class="form-group col-md-3">
            <label for="departure_date" class="font-weight-bold text-dark" style="font-size: 14px;">Departure Date</label>
            <input type="date" id="departure_date" name="departure_date" class="form-control" placeholder="Departure Date" value="{{ session('form.step_3.departure_date') }}">
        </div>
    
        <div class="form-group col-md-3">
            <label for="arrival_date" class="font-weight-bold text-dark" style="font-size: 14px;">Arrival Date</label>
            <input type="date" id="arrival_date" name="arrival_date" class="form-control" placeholder="Arrival Date" value="{{ session('form.step_3.arrival_date') }}">
        </div>
    
        <div class="form-group col-md-3">
            <label for="departure_seal" class="font-weight-bold text-dark" style="font-size: 14px;">Departure Seal</label>
            <input type="file" id="departure_seal" name="departure_seal" class="form-control">
        </div>
    
        <div class="form-group col-md-3">
            <label for="arrival_seal" class="font-weight-bold text-dark" style="font-size: 14px;">Arrival Seal</label>
            <input type="file" id="arrival_seal" name="arrival_seal" class="form-control">
        </div>
    
        <div class="form-group col-md-6">
            <label for="travelled_country_id" class="font-weight-bold text-dark" style="font-size: 14px;">Travelled Country</label>
            <select id="travelled_country_id" name="travelled_country_id[]" class="form-control select2" multiple>
                <option value="">--Select One--</option>
                @foreach ($travelledCountries as $id => $name)
                    <option value="{{ $id }}"
                        @if(is_array(session('form.step_3.travelled_country_id')) && in_array($id, session('form.step_3.travelled_country_id')))
                            selected
                        @endif
                    >{{ $name }}</option>
                @endforeach
            </select>
        </div>
    
        <div class="form-group col-md-12">
            <label for="old_company_address" class="font-weight-bold text-dark" style="font-size: 14px;">Old Company Address</label>
            <textarea id="old_company_address" name="old_company_address" class="form-control" placeholder="Old Company Address" rows="2">{{ session('form.step_3.old_company_address') }}</textarea>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        function toggleExperienceFields() {
            const experienceType = $('#experience_type').val();
            if (experienceType === 'experienced') {
                $('#experienceFieldsWrapper').slideDown();
            } else {
                $('#experienceFieldsWrapper').slideUp();
            }
        }

        toggleExperienceFields();

        $('#experience_type').on('change', function () {
            toggleExperienceFields();
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function() {

    function updateFields(candidateTypeId) {
        if (!candidateTypeId) return;

        $.ajax({
            url: '/admin/fields-status/' + candidateTypeId,
            type: 'GET',
            success: function(fields) {
                console.log('Fields from server:', fields);

                // Loop through all inputs/selects in this step dynamically
                $('input, select, textarea').each(function() {
                    let id = $(this).attr('id');
                    if(fields.hasOwnProperty(id)) {
                        $(this).prop('disabled', fields[id] == 0);
                        if($(this).hasClass('select2-hidden-accessible')) {
                            $(this).trigger('change.select2');
                        }
                    }
                });
            },
            error: function() {
                console.log('Unable to fetch fields status');
            }
        });
    }

    // Step 3: Get candidate_type_id from hidden input
    let candidateTypeId = $('#candidate_type_id_hidden').val();
    if(candidateTypeId) {
        updateFields(candidateTypeId);
    }
});
</script>
