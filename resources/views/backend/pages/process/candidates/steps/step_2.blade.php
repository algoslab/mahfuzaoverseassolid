<div class="row">
    <div class="form-group col-md-3">
        <label for="first_name" class="font-weight-bold text-dark" style="font-size: 14px;">First Name</label>
        <input type="text" id="first_name" name="first_name" class="form-control" placeholder="First Name" value="{{ session('form.step_2.first_name') }}">
    </div>

    <div class="form-group col-md-3">
        <label for="last_name" class="font-weight-bold text-dark" style="font-size: 14px;">Last Name</label>
        <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last Name" value="{{ session('form.step_2.last_name') }}">
    </div>

    <div class="form-group col-md-3">
        <label for="gender_id" class="font-weight-bold text-dark" style="font-size: 14px;">Gender</label>
        <select id="gender_id" name="gender_id" class="form-control select2">
            <option value="">--Select One--</option>
            @foreach ($genders as $id => $name)
                <option value="{{ $id }}" 
                    {{ session('form.step_2.gender_id') == $id ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-3">
        <label for="date_of_birth" class="font-weight-bold text-dark" style="font-size: 14px;">Date of birth</label>
        <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" placeholder="Date of birth" value="{{ session('form.step_2.date_of_birth') }}">
    </div>

    <div class="form-group col-md-3">
        <label for="email" class="font-weight-bold text-dark" style="font-size: 14px;">Email</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="{{ session('form.step_2.email') }}">
    </div>

    <div class="form-group col-md-3">
        <label for="phone_number" class="font-weight-bold text-dark" style="font-size: 14px;">Phone Number</label>
        <input type="number" id="phone_number" name="phone_number" class="form-control" placeholder="Phone Number" value="{{ session('form.step_2.phone_number') }}">
    </div>

    <div class="form-group col-md-3">
        <label for="contact_person_number" class="font-weight-bold text-dark" style="font-size: 14px;">Contact Person Number</label>
        <input type="number" id="contact_person_number" name="contact_person_number" class="form-control" placeholder="Contact Person Number" value="{{ session('form.step_2.contact_person_number') }}">
    </div>

    <div class="form-group col-md-3">
        <label for="nid_or_birth_certificate" class="font-weight-bold text-dark" style="font-size: 14px;">NID / Birth Certificate</label>
        <input type="text" id="nid_or_birth_certificate" name="nid_or_birth_certificate" class="form-control" placeholder="NID / Birth Certificate" value="{{ session('form.step_2.nid_or_birth_certificate') }}">
    </div>

    <div class="form-group col-md-3">
        <label for="father_name" class="font-weight-bold text-dark" style="font-size: 14px;">Father Name</label>
        <input type="text" id="father_name" name="father_name" class="form-control" placeholder="Father Name" value="{{ session('form.step_2.father_name') }}">
    </div>

    <div class="form-group col-md-3">
        <label for="mother_name" class="font-weight-bold text-dark" style="font-size: 14px;">Mother Name</label>
        <input type="text" id="mother_name" name="mother_name" class="form-control" placeholder="Mother Name" value="{{ session('form.step_2.mother_name') }}">
    </div>

    <div class="form-group col-md-3">
        <label for="marital_status" class="font-weight-bold text-dark" style="font-size: 14px;">Marital status</label>
        <select id="marital_status" name="marital_status" class="form-control select2">
            <option value="">--Select One--</option>
            <option value="single" {{ session('form.step_2.marital_status') == 'single' ? 'selected' : '' }}>Single</option>
            <option value="married" {{ session('form.step_2.marital_status') == 'married' ? 'selected' : '' }}>Married</option>
            <option value="seperated" {{ session('form.step_2.marital_status') == 'seperated' ? 'selected' : '' }}>Seperated</option>
            <option value="widowed" {{ session('form.step_2.marital_status') == 'widowed' ? 'selected' : '' }}>Widowed</option>
            <option value="not_specified" {{ session('form.step_2.marital_status') == 'not_specified' ? 'selected' : '' }}>Not Specified</option>
        </select>
    </div>

    <div class="form-group col-md-3">
        <label for="spouse_name" class="font-weight-bold text-dark" style="font-size: 14px;">Spouse Name</label>
        <input type="text" id="spouse_name" name="spouse_name" class="form-control" placeholder="Spouse Name" value="{{ session('form.step_2.spouse_name') }}">
    </div>

    <div class="form-group col-md-3">
        <label for="nominee_name" class="font-weight-bold text-dark" style="font-size: 14px;">Nominee Name</label>
        <input type="text" id="nominee_name" name="nominee_name" class="form-control" placeholder="Nominee Name" value="{{ session('form.step_2.nominee_name') }}">
    </div>

    <div class="form-group col-md-3">
        <label for="relation_with_nominee_id" class="font-weight-bold text-dark" style="font-size: 14px;">Relation With Nominee</label>
        <select id="relation_with_nominee_id" name="relation_with_nominee_id" class="form-control select2">
            <option value="">--Select One--</option>
            @foreach($relations as $id => $name)
                <option value="{{ $id }}" 
                    {{ session('form.step_2.relation_with_nominee_id') == $id ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-3">
        <label for="religion_id" class="font-weight-bold text-dark" style="font-size: 14px;">Religion</label>
        <select id="religion_id" name="religion_id" class="form-control select2">
            <option value="">--Select One--</option>
            @foreach ($religions as $id => $name)
                <option value="{{ $id }}" 
                    {{ session('form.step_2.religion_id') == $id ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-3">
        <label for="blood_group_id" class="font-weight-bold text-dark" style="font-size: 14px;">Blood group</label>
        <select id="blood_group_id" name="blood_group_id" class="form-control select2">
            <option value="">--Select One--</option>
            @foreach ($bloodGroups as $id => $name)
                <option value="{{ $id }}" 
                    {{ session('form.step_2.blood_group_id') == $id ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-12">
        <label for="note" class="font-weight-bold text-dark" style="font-size: 14px;">Note</label>
        <textarea id="note" name="note" class="form-control" placeholder="Note" rows="2">{{ session('form.step_2.note') }}</textarea>
    </div>
</div>