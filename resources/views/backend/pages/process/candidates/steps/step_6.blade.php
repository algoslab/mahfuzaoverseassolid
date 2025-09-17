<input type="hidden" id="candidate_type_id_hidden" value="{{ session('form.step_1.candidate_type_id') }}">

<div class="row" id="step6_container">
    <div class="form-group col-md-6">
        <label for="candidate_photo" class="form-label">Candidate Photo <span class="text-danger">*</span></label>
        <input type="file" name="candidate_photo" id="candidate_photo" class="form-control">
    </div>
    <div class="form-group col-md-6">
        <label for="police_verification" class="form-label">Police Verification</label>
        <input type="file" name="police_verification" id="police_verification" class="form-control">
    </div>
    <div class="form-group col-md-6">
        <label for="other_certification" class="form-label">Other Certification</label>
        <input type="file" name="other_certification" id="other_certification" class="form-control">
    </div>
    <div class="form-group col-md-6">
        <label for="optional_file" class="form-label">Optional File</label>
        <input type="file" name="optional_file" id="optional_file" class="form-control">
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function() {
    function updateStep6Fields(candidateTypeId) {
        if (!candidateTypeId) return;

        $.ajax({
            url: '/admin/fields-status/' + candidateTypeId,
            type: 'GET',
            success: function(fields) {
                console.log('Step 6 fields from server:', fields);

                // Loop only inside Step 6 container
                $('#step6_container').find('input, select, textarea').each(function() {
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
                console.log('Unable to fetch Step 6 fields status');
            }
        });
    }

    // Get candidate_type_id from hidden input
    let candidateTypeId = $('#candidate_type_id_hidden').val();
    if(candidateTypeId) {
        updateStep6Fields(candidateTypeId);
    }
});
</script>
