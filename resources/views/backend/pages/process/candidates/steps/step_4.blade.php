<input type="hidden" id="candidate_type_id_hidden" value="{{ session('form.step_1.candidate_type_id') }}">
<div id="step4_container">
<div class="row form-group col-md-3">
    <label for="passport_type" class="font-weight-bold text-dark" style="font-size: 14px;">Passport Type</label>
    <select id="passport_type" name="passport_type" class="form-control select2">
        <option value="">--Select One--</option>
        <option value="no_passport" {{ session('form.step_4.passport_type') == 'no_passport' ? 'selected' : '' }}>NoPassport</option>
        <option value="ordinary" {{ session('form.step_4.passport_type') == 'ordinary' ? 'selected' : '' }}>Ordinary</option>
        <option value="official" {{ session('form.step_4.passport_type') == 'official' ? 'selected' : '' }}>Official</option>
        <option value="diplomatic" {{ session('form.step_4.passport_type') == 'diplomatic' ? 'selected' : '' }}>Diplomatic</option>
        <option value="special" {{ session('form.step_4.passport_type') == 'special' ? 'selected' : '' }}>Special</option>
    </select>
</div>

<div class="row">
    <div class="form-group col-md-3">
        <label for="passport_number" class="font-weight-bold text-dark" style="font-size: 14px;">Passport Number</label>
        <input type="text" id="passport_number" name="passport_number" class="form-control" placeholder="Passport Number" value="{{ session('form.step_4.passport_number') }}">
    </div>

    <div class="form-group col-md-3">
        <label for="passport_issue_date" class="font-weight-bold text-dark" style="font-size: 14px;">Passport Issue Date</label>
        <input type="date" id="passport_issue_date" name="passport_issue_date" class="form-control" placeholder="Passport Issue Date" value="{{ session('form.step_4.passport_issue_date') }}">
    </div>

    <div class="form-group col-md-3">
        <label for="passport_expired_date" class="font-weight-bold text-dark" style="font-size: 14px;">Passport Expired Date</label>
        <input type="date" id="passport_expired_date" name="passport_expired_date" class="form-control" placeholder="Passport Expired Date" value="{{ session('form.step_4.passport_expired_date') }}">
    </div>

    <div class="form-group col-md-3">
        <label for="passport_issue_place_id" class="font-weight-bold text-dark" style="font-size: 14px;">Passport Issue Place</label>
        <select id="passport_issue_place_id" name="passport_issue_place_id" class="form-control select2">
            <option value="">--Select One--</option>
            @foreach ($passportIssuePlaces as $id => $name)
                <option value="{{ $id }}" 
                    {{ session('form.step_4.passport_issue_place_id') == $id ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-3">
        <label for="validity_years" class="font-weight-bold text-dark" style="font-size: 14px;">Validity Year</label>
        <select id="validity_years" name="validity_years" class="form-control">
            <option value="">--Select One--</option>
            <option value="5" {{ session('form.step_4.validity_years') == '5' ? 'selected' : '' }}>5 Years</option>
            <option value="10" {{ session('form.step_4.validity_years') == '10' ? 'selected' : '' }}>10 Years</option>
        </select>
    </div>

    <div class="form-group col-md-3">
        <label for="passport_scan_copy" class="font-weight-bold text-dark" style="font-size: 14px;">Passport Scan Copy</label>
        <input type="file" id="passport_scan_copy" name="passport_scan_copy" class="form-control">
    </div>
    <div class="form-group col-md-3">
        <label for="nfc_tag" class="font-weight-bold text-dark" style="font-size: 14px;">NFC Tag</label>
        <input type="text" id="nfc_tag" name="nfc_tag" class="form-control">
    </div>

    <div class="form-group col-md-12">
        <label for="note" class="font-weight-bold text-dark" style="font-size: 14px;">Note</label>
        <textarea id="note" name="note" class="form-control" placeholder="Note" rows="2">{{ session('form.step_4.note') }}</textarea>
    </div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function() {

    function updateStep4Fields(candidateTypeId) {
        if (!candidateTypeId) return;

        $.ajax({
            url: '/admin/fields-status/' + candidateTypeId,
            type: 'GET',
            success: function(fields) {
                console.log('Step 4 fields from server:', fields);

                $('#step4_container').find('input, select, textarea').each(function() {
                    let id = $(this).attr('id');
                    if(fields.hasOwnProperty(id)) {
                        $(this).prop('disabled', fields[id] == 0);

                        // Refresh select2 UI if needed
                        if($(this).hasClass('select2-hidden-accessible')) {
                            $(this).trigger('change.select2');
                        }
                    }
                });
            },
            error: function() {
                console.log('Unable to fetch Step 4 fields status');
            }
        });
    }

    // Initial load (if hidden input already has value)
    let candidateTypeId = $('#candidate_type_id_hidden').val();
    if(candidateTypeId) {
        updateStep4Fields(candidateTypeId);
    }

    // Listen to sidebar select change
    $('#candidate_type_id').on('change', function() {
        let newCandidateTypeId = $(this).val();
        // Update hidden input as well
        $('#candidate_type_id_hidden').val(newCandidateTypeId);
        updateStep4Fields(newCandidateTypeId);
    });

});
</script>
