<div>
    <h5 id="manageFormForm"><strong>{{ $candidateType->name }}'s</strong> Form Management</h5>

    <div class="modal-body candidate_type_form_management_modal_body" style="overflow-x: hidden;">
        <div class="row">
            <div class="col-sm-12">
                <form class="candidate_form_management" id="manageFormForm">

                    @php
                        $sections = [
                            'New Candidate' => [
                                ['name'=>'candidate_type_id', 'attr'=>'candidate_type_id', 'recommended'=>true],
                                ['name'=>'Referral Agent', 'attr'=>'referral_agent_id', 'recommended'=>true],
                                ['name'=>'Interested Country', 'attr'=>'interested_country_id', 'recommended'=>true],
                                ['name'=>'Interested Profession', 'attr'=>'interested_profession_id', 'recommended'=>true],
                                ['name'=>'Nationality', 'attr'=>'nationality', 'recommended'=>false],
                            ],
                            'Personal Information' => [
                                ['name'=>'First name', 'attr'=>'first_name', 'recommended'=>true],
                                ['name'=>'Last name', 'attr'=>'last_name', 'recommended'=>true],
                                ['name'=>'Gender', 'attr'=>'gender_id', 'recommended'=>true],
                                ['name'=>'Date of birth', 'attr'=>'date_of_birth', 'recommended'=>true],
                                ['name'=>'Email', 'attr'=>'email', 'recommended'=>false],
                                ['name'=>'Phone Number', 'attr'=>'phone_number', 'recommended'=>true],
                                ['name'=>'Contact Person Number', 'attr'=>'contact_person_number', 'recommended'=>false],
                                ['name'=>'NID / Birth Certificate', 'attr'=>'nid_or_birth_certificate', 'recommended'=>true],
                                ['name'=>'Father Name', 'attr'=>'father_name', 'recommended'=>false],
                                ['name'=>'Mother Name', 'attr'=>'mother_name', 'recommended'=>false],
                                ['name'=>'Marital status', 'attr'=>'marital_status', 'recommended'=>false],
                                ['name'=>'Spouse Name', 'attr'=>'spouse_name', 'recommended'=>false],
                                ['name'=>'Nominee Name', 'attr'=>'nominee_name', 'recommended'=>false],
                                ['name'=>'Relation With Nominee', 'attr'=>'relation_with_nominee_id', 'recommended'=>false],
                                ['name'=>'Choose Religion', 'attr'=>'religion_id', 'recommended'=>false],
                                ['name'=>'Blood group', 'attr'=>'blood_group_id', 'recommended'=>false],
                                ['name'=>'Note', 'attr'=>'note', 'recommended'=>false],
                            ],
                            'Experience Information' => [
                                ['name'=>'Experiance Type', 'attr'=>'experience_type', 'recommended'=>false],
                            ],
                            'Passport Information' => [
                                ['name'=>'Passport Type', 'attr'=>'passport_type', 'recommended'=>true],
                                ['name'=>'Passport Number', 'attr'=>'passport_number', 'recommended'=>true],
                                ['name'=>'Passport Issue Date', 'attr'=>'passport_issue_date', 'recommended'=>true],
                                ['name'=>'Passport Expired Date', 'attr'=>'passport_expired_date', 'recommended'=>true],
                                ['name'=>'Passport Issue Place', 'attr'=>'passport_issue_place_id', 'recommended'=>false],
                                ['name'=>'Validity Year', 'attr'=>'validity_years', 'recommended'=>true],
                                ['name'=>'Passport Scan Copy', 'attr'=>'passport_scan_copy', 'recommended'=>false],
                                ['name'=>'Passport Note', 'attr'=>'note', 'recommended'=>false],
                                ['name'=>'NFC Tag', 'attr'=>'nfc_tag', 'recommended'=>false],
                            ],
                            'Location' => [
                            ['name' => 'Choose Country', 'attr' => 'country_id', 'recommended' => false],
                            ['name' => 'Choose Division', 'attr' => 'division_id', 'recommended' => false],
                            ['name' => 'Choose District', 'attr' => 'district_id', 'recommended' => false],
                            ['name' => 'Choose Thana', 'attr' => 'thana_id', 'recommended' => false],
                            ['name' => 'Choose PostOffice', 'attr' => 'post_office_id', 'recommended' => false],
                            ['name' => 'Choose State', 'attr' => 'state_id', 'recommended' => false],
                            ['name' => 'Current address', 'attr' => 'current_address', 'recommended' => false],
                            ['name' => 'Permanent address', 'attr' => 'permanent_address', 'recommended' => false],
                        ],
                    'Files' => [
                        ['name' => 'Candidate photo', 'attr' => 'candidate_photo', 'recommended' => true],
                        ['name' => 'Police Verification', 'attr' => 'police_verification', 'recommended' => false],
                        ['name' => 'Other Certification', 'attr' => 'other_certification', 'recommended' => false],
                        ['name' => 'Optional File/Files', 'attr' => 'optional_file', 'recommended' => false],
                    ],

                        ];
                    @endphp

                    @foreach($sections as $sectionName => $fields)
                        <div class="col-sm-12">
                            <b>{{ $loop->iteration }}. {{ $sectionName }}</b>
                            <hr class="m-10">
                            <div class="row">
                                @foreach($fields as $index => $field)
                                    @php
                                        $checkboxId = 'candidate_field_'.$sectionName.'_'.$index;
                                        // Check if the attr_value exists in $savedFields and if its value is 1 (true)
                                        // Use array_key_exists for robust checking as value could be 0
                                        $isChecked = array_key_exists($field['attr'], $savedFields) ? $savedFields[$field['attr']] : 1;
                                        // If not found in DB, default to checked (1), or you can default to 0 (unchecked)
                                    @endphp
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox"
                                                       id="{{ $checkboxId }}"
                                                       class="candidate-field-checkbox"
                                                       data-type-id="{{ $candidateType->id }}"
                                                       data-step-name="{{ $sectionName }}"
                                                       data-field-name="{{ $field['name'] }}"
                                                       data-attr-value="{{ $field['attr'] }}"
                                                       {{ $isChecked ? 'checked' : '' }}>
                                                <label for="{{ $checkboxId }}">
                                                    {{ $field['name'] }}
                                                    @if($field['recommended'])
                                                        <br><small>(Recommended)</small>
                                                    @endif
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <hr class="m-10">
                        </div>
                    @endforeach

                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Your existing AJAX script for toggling fields remains the same
// Make sure the route name matches your web.php: admin.candidateTypes.toggleField
$(document).on('change', '.candidate-field-checkbox', function() {
    const checkbox = $(this);
    const typeId = checkbox.data('type-id');
    const stepName = checkbox.data('step-name');
    const fieldName = checkbox.data('field-name');
    const attrValue = checkbox.data('attr-value');
    const isEnable = checkbox.is(':checked') ? 1 : 0;

    $.ajax({
        url: '{{ route("admin.candidateTypes.toggleField") }}', // Corrected route name based on your provided web.php
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            candidate_type_id: typeId,
            step_name: stepName,
            field_name: fieldName,
            attr_value: attrValue,
            is_enable: isEnable
        },
        success: function(res) {
            if(res.success){
                console.log(`${fieldName} is now ${isEnable ? 'enabled' : 'disabled'}`);
            } else {
                console.log('Error saving field status');
            }
        },
        error: function(err){
            console.log('AJAX error', err);
        }
    });
});
</script>