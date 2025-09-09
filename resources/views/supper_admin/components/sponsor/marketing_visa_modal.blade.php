<div class="modal fade" id="modal-center" tabindex="-1" aria-labelledby="modalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Marketing Visa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- The Form -->
            <form id="visaForm">
                @csrf
                <input type="hidden" id="marketing_visa_id" name="marketing_visa_id" value="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Choose Country</label>
                                <select name="country_id" id="countrySelect" class="form-control">
                                    <option value="" disabled selected>Choose Country</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Choose Occupation</label>
                                <select name="job_list_id" id="jobSelect" class="form-control">
                                    <option value="" disabled selected>Choose Occupation</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Choose Type</label>
                                <select name="type" id="type" class="form-control" required>
                                    <option value="" disabled selected>Choose Type</option>
                                    <option value="Air Ticket">Air Ticket</option>
                                    <option value="Business Visa">Business Visa</option>
                                    <option value="Hazz & Umrah">Hazz & Umrah</option>
                                    <option value="Manpower">Manpower</option>
                                    <option value="Patient">Patient</option>
                                    <option value="Tourist">Tourist</option>
                                    <option value="Visa Processing">Visa Processing</option>
                                    <option value="Worker">Worker</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Choose Gender</label>
                                <select name="gender" id="gender" class="form-control" required>
                                    <option value="" disabled selected>Choose Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Haji">Haji</option>
                                </select> </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Monthly Salary</label>
                                <input type="number" step="any" name="monthly_salary" id="monthly_salary" placeholder="Monthly Salary" class="form-control" required="">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="salary_currency_id" class="font-weight-bold text-dark" style="font-size: 14px;">Currency</label>
                                    <select name="salary_currency_id" id="salaryCurrencySelect" class="form-control" required>
                                        <option value="" disabled selected>Choose Currency</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Cost</label>
                                <input type="number" step="any" name="cost" id="cost" placeholder="Cost" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="cost_currency_id" class="font-weight-bold text-dark" style="font-size: 14px;">Cost Currency</label>
                                <select name="cost_currency_id" id="costCurrencySelect" class="form-control">
                                    <option value="" disabled selected>Choose Currency</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Available Quantity</label>
                                <input type="number" step="any" name="available_qty" id="available_qty" placeholder="Available Quantity" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Registration Fee</label>
                                <input type="number" step="any" name="registration_fee" id="registration_fee" placeholder="Registration Fee" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="checkbox checkbox-success">
                            <input name="send_sms_to_agent" id="send_sms_to_agent" type="checkbox">
                            <label for="send_sms_to_agent"> Send SMS to Agent </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Attachment <span class="attachment"></span></label>
                        <input type="file" style="padding: 3px;" name="attachment" class="form-control">
                        <!-- Existing file preview -->
                        <div id="existing-file-preview" style="margin-top: 10px;"></div>

                        <!-- Remove file toggle -->
                        <div id="remove-file-section" class="form-check mt-2 d-none">
                            <input type="checkbox" class="form-check-input" id="remove_file" name="remove_file" value="1">
                            <label class="form-check-label" for="remove_file">Remove existing file</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Note</label>
                        <textarea name="note" class="form-control" placeholder="Note"></textarea>
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



