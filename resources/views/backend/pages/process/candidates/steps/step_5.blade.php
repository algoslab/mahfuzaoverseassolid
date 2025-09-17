<input type="hidden" id="candidate_type_id_hidden" value="{{ session('form.step_1.candidate_type_id') }}">

<div id="step5_container" class="row">
    <div class="form-group col-md-3">
        <label for="country_id" class="font-weight-bold text-dark" style="font-size: 14px;">Country</label>
        <select id="country_id" name="country_id" class="form-control select2">
            <option value="">--Select One--</option>
            @foreach ($countries as $id => $name)
                <option value="{{ $id }}" {{ session('form.step_5.country_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-3">
        <label for="division_id" class="font-weight-bold text-dark" style="font-size: 14px;">Division</label>
        <select id="division_id" name="division_id" class="form-control select2">
            <option value="">--Select One--</option>
            @foreach ($divisions as $id => $name)
                <option value="{{ $id }}" {{ session('form.step_5.division_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-3">
        <label for="district_id" class="font-weight-bold text-dark" style="font-size: 14px;">District</label>
        <select id="district_id" name="district_id" class="form-control select2">
            <option value="">--Select One--</option>
            @foreach ($districts as $id => $name)
                <option value="{{ $id }}" {{ session('form.step_5.district_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-3">
        <label for="thana_id" class="font-weight-bold text-dark" style="font-size: 14px;">Thana</label>
        <select id="thana_id" name="thana_id" class="form-control select2">
            <option value="">--Select One--</option>
            @foreach ($thanas as $id => $name)
                <option value="{{ $id }}" {{ session('form.step_5.thana_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-3">
        <label for="post_office_id" class="font-weight-bold text-dark" style="font-size: 14px;">Post Office</label>
        <select id="post_office_id" name="post_office_id" class="form-control select2">
            <option value="">--Select One--</option>
            @foreach ($postOffices as $id => $name)
                <option value="{{ $id }}" {{ session('form.step_5.post_office_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-3">
        <label for="state_id" class="font-weight-bold text-dark" style="font-size: 14px;">State</label>
        <select id="state_id" name="state_id" class="form-control select2">
            <option value="">--Select One--</option>
            @foreach ($states as $id => $name)
                <option value="{{ $id }}" {{ session('form.step_5.state_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-12">
        <label for="current_address" class="font-weight-bold text-dark" style="font-size: 14px;">Current Address</label>
        <textarea id="current_address" name="current_address" class="form-control" placeholder="Current Address" rows="2">{{ session('form.step_5.current_address') }}</textarea>
    </div>

    <div class="form-group col-md-12">
        <label for="permanent_address" class="font-weight-bold text-dark" style="font-size: 14px;">Permanent Address</label>
        <textarea id="permanent_address" name="permanent_address" class="form-control" placeholder="Permanent Address" rows="2">{{ session('form.step_5.permanent_address') }}</textarea>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function() {

    // Enable/disable Step 5 fields based on candidate type
    function updateStep5Fields(candidateTypeId) {
        if (!candidateTypeId) return;

        $.ajax({
            url: '/admin/fields-status/' + candidateTypeId,
            type: 'GET',
            success: function(fields) {
                console.log('Step 5 fields from server:', fields);

                $('#step5_container').find('input, select, textarea').each(function() {
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
                console.log('Unable to fetch Step 5 fields status');
            }
        });
    }

    // Get candidate_type_id from hidden input
    let candidateTypeId = $('#candidate_type_id_hidden').val();
    if(candidateTypeId) {
        updateStep5Fields(candidateTypeId);
    }

    // Cascading dropdowns
    $(document).on('change', '#country_id', function() {
        var countryId = $(this).val();

        // Divisions
        $.get('/admin/location/divisions/' + countryId, function(data) {
            var $division = $('#division_id');
            $division.empty().append('<option value="">--Select One--</option>');
            $.each(data, function(id, name) { $division.append('<option value="'+id+'">'+name+'</option>'); });
            $division.trigger('change');
        });

        // States
        $.get('/admin/location/states/' + countryId, function(data) {
            var $state = $('#state_id');
            $state.empty().append('<option value="">--Select One--</option>');
            $.each(data, function(id, name) { $state.append('<option value="'+id+'">'+name+'</option>'); });
        });
    });

    $(document).on('change', '#division_id', function() {
        var divisionId = $(this).val();

        $.get('/admin/location/districts/' + divisionId, function(data) {
            var $district = $('#district_id');
            $district.empty().append('<option value="">--Select One--</option>');
            $.each(data, function(id, name) { $district.append('<option value="'+id+'">'+name+'</option>'); });
            $district.trigger('change');
        });
    });

    $(document).on('change', '#district_id', function() {
        var districtId = $(this).val();

        // Thanas
        $.get('/admin/location/thanas/' + districtId, function(data) {
            var $thana = $('#thana_id');
            $thana.empty().append('<option value="">--Select One--</option>');
            $.each(data, function(id, name) { $thana.append('<option value="'+id+'">'+name+'</option>'); });
        });

        // Post offices
        $.get('/admin/location/postoffices/' + districtId, function(data) {
            var $postOffice = $('#post_office_id');
            $postOffice.empty().append('<option value="">--Select One--</option>');
            $.each(data, function(id, name) { $postOffice.append('<option value="'+id+'">'+name+'</option>'); });
        });
    });

});
</script>
