<div class="row form-group col-md-3">
    <label for="candidate_type_id" class="font-weight-bold text-dark" style="font-size: 14px;">Candidate Type</label>
    <select id="candidate_type_id" name="candidate_type_id" class="form-control select2">
        <option value="">--Select One--</option>
        @foreach($candidateTypes as $id => $name)
            <option value="{{ $id }}" 
                {{ session('form.step_1.candidate_type_id') == $id ? 'selected' : '' }}>
                {{ $name }}
            </option>
        @endforeach
    </select>
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