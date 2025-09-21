<div class="modal fade" id="modal-center" tabindex="-1" aria-labelledby="modalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Dynamic Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- The Form -->
            <form id="dynamicForm">
                @csrf
                <input type="hidden" id="dynamic_form_id" name="dynamic_form_id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Form Name</label>
                        <input type="text" name="form_name" id="form_name" placeholder="Form Name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Select Fields</label>
                        <select name="field_name[]" id="field_name" class="form-control select2" multiple required>
                            <option value="id">id</option>
                            <option value="candidate_type_id">candidate_type_id</option>
                            <option value="candidate_type">candidate_type</option>
                            <option value="is_tourist">is_tourist</option>
                            <option value="agent_id">agent_id</option>
                            <option value="agent_name">agent_name</option>
                            <option value="referral_employee_id">referral_employee_id</option>
                            <option value="referral_employee_name">referral_employee_name</option>
                            <option value="interested_country_id">interested_country_id</option>
                            <option value="interested_country_name">interested_country_name</option>
                            <option value="interested_job_id">interested_job_id</option>
                            <option value="interested_job_name">interested_job_name</option>
                            <option value="process_country_id">process_country_id</option>
                            <option value="process_country_name">process_country_name</option>
                            <option value="process_job_id">process_job_id</option>
                            <option value="process_job_name">process_job_name</option>
                            <option value="nationality">nationality</option>
                            <option value="first_name">first_name</option>
                            <option value="last_name">last_name</option>
                            <option value="full_name">full_name</option>
                            <option value="gender">gender</option>
                            <option value="date_of_birth">date_of_birth</option>
                            <option value="email">email</option>
                            <option value="phone_number">phone_number</option>
                            <option value="password">password</option>
                            <option value="contact_number">contact_number</option>
                            <option value="nid_number">nid_number</option>
                            <option value="father_name">father_name</option>
                            <option value="mother_name">mother_name</option>
                            <option value="spouse_name">spouse_name</option>
                            <option value="nominee_name">nominee_name</option>
                            <option value="religion">religion</option>
                            <option value="marital_status">marital_status</option>
                            <option value="blood_group">blood_group</option>
                            <option value="nominee_relation">nominee_relation</option>
                            <option value="note">note</option>
                            <option value="experience_type">experience_type</option>
                            <option value="old_company_name">old_company_name</option>
                            <option value="old_job_id">old_job_id</option>
                            <option value="old_job_name">old_job_name</option>
                            <option value="departure_date">departure_date</option>
                            <option value="arrival_date">arrival_date</option>
                            <option value="departure_seal">departure_seal</option>
                            <option value="arrival_seal">arrival_seal</option>
                            <option value="old_company_address">old_company_address</option>
                            <option value="travelled_country_ids">travelled_country_ids</option>
                            <option value="passport_type">passport_type</option>
                            <option value="passport_number">passport_number</option>
                            <option value="old_passport_number">old_passport_number</option>
                            <option value="passport_issue_date">passport_issue_date</option>
                            <option value="passport_expired_date">passport_expired_date</option>
                            <option value="passport_issue_place">passport_issue_place</option>
                            <option value="passport_issue_place_name">passport_issue_place_name</option>
                            <option value="validity_year">validity_year</option>
                            <option value="passport_scan_copy">passport_scan_copy</option>
                            <option value="passport_note">passport_note</option>
                            <option value="country_id">country_id</option>
                            <option value="country_name">country_name</option>
                            <option value="division_id">division_id</option>
                            <option value="division_name">division_name</option>
                            <option value="district_id">district_id</option>
                            <option value="district_name">district_name</option>
                            <option value="thana_id">thana_id</option>
                            <option value="thana_name">thana_name</option>
                            <option value="postoffice_id">postoffice_id</option>
                            <option value="postoffice_name">postoffice_name</option>
                            <option value="postoffice_code">postoffice_code</option>
                            <option value="state_id">state_id</option>
                            <option value="state_name">state_name</option>
                            <option value="current_address">current_address</option>
                            <option value="permanent_address">permanent_address</option>
                            <option value="candidate_photo">candidate_photo</option>
                            <option value="polication_verification_file">polication_verification_file</option>
                            <option value="other_certification">other_certification</option>
                            <option value="optional_files">optional_files</option>
                            <option value="comments">comments</option>
                            <option value="commission_amount">commission_amount</option>
                            <option value="is_child">is_child</option>
                            <option value="status">status</option>
                            <option value="visa_id">visa_id</option>
                            <option value="sponsor_id">sponsor_id</option>
                            <option value="sponsor_name">sponsor_name</option>
                            <option value="is_start">is_start</option>
                            <option value="is_completed">is_completed</option>
                            <option value="running_step">running_step</option>
                            <option value="total_step">total_step</option>
                            <option value="is_duplicate">is_duplicate</option>
                            <option value="terminated_note">terminated_note</option>
                            <option value="terminated_attachment">terminated_attachment</option>
                            <option value="uploader_info">uploader_info</option>
                            <option value="data">data</option>
                            <option value="date_filter">date_filter</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Background image <span class="background_image"></span></label>
                        <input type="file" name="background_image" id="background_image" class="form-control">
                        <div id="imagePreviewContainer" style="margin-top: 10px;">
                            <img id="preview" src="" style="max-width: 100px; display: none;" />
                        </div>
                        <!-- Remove file toggle -->
                        <div id="remove-file-section" class="form-check mt-2 d-none">
                            <input type="checkbox" class="form-check-input" id="remove_file" name="remove_file" value="1">
                            <label class="form-check-label" for="remove_file">Remove existing file</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Note</label>
                        <textarea name="note" id="note" class="form-control" placeholder="Note"></textarea>
                    </div>

                    <div class="form-group form-check">
                        <input type="checkbox" id="status" name="status" class="form-check-input" value="Enabled" checked>
                        <label class="form-check-label" for="status">Status</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
         </div>
    </div>
</div>



