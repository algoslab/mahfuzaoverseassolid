<div class="modal fade" id="modal-center" tabindex="-1" aria-labelledby="modalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success p-4">
                <h5 class="modal-title" id="modalTitle">Add Agent Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- The Form -->
            <form id="agentForm" enctype="multipart/form-data" method="POST">
                @csrf
                <input type="hidden" id="agent_id" name="agent_id" value="">
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="first_name" class="font-weight-bold text-dark" style="font-size: 14px;">First Name</label>
                                <input type="text" id="first_name" name="first_name" class="form-control" placeholder="Enter First Name" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="last_name" class="font-weight-bold text-dark" style="font-size: 14px;">Last Name</label>
                                <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Enter First Name" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone_number" class="font-weight-bold text-dark" style="font-size: 14px;">Phone Number</label>
                                <input type="text" id="phone_number" name="phone_number" class="form-control" placeholder="Enter First Name" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email" class="font-weight-bold text-dark" style="font-size: 14px;">Email</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Enter First Name" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="date_of_birth" class="font-weight-bold text-dark" style="font-size: 14px;">Date Of Birth</label>
                                <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" placeholder="Enter First Name" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="agent_photo" class="font-weight-bold text-dark" style="font-size: 14px;">Agent Photo</label>
                                 <input type="file" id="agent_photo" name="agent_photo" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="passport_scan_copy" class="font-weight-bold text-dark" style="font-size: 14px;">Passport Scan Copy</label>
                                 <input type="file" id="passport_scan_copy" name="passport_scan_copy" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Select Country </label>
                                <select name="country_id" id="countriesSelect" class="form-control " required>
                                    <option value="" disabled selected>Select a Country</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="districtsSelect" class="font-weight-bold text-dark" style="font-size: 14px;">Select District </label>
                                <select name="district_id" id="districtsSelect" class="form-control " required>
                                    <option value="" disabled selected>Select a District</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="divisionsSelect" class="font-weight-bold text-dark" style="font-size: 14px;">Select Division </label>
                                <select name="division_id" id="divisionsSelect" class="form-control " required>
                                    <option value="" disabled selected >Select a Division</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="thanasSelect" class="font-weight-bold text-dark" style="font-size: 14px;">Select Thana </label>
                                <select name="thana_id" id="thanasSelect" class="form-control " required>
                                    <option value="" disabled selected>Select a Thana</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="current_address" class="font-weight-bold text-dark" style="font-size: 14px;">Current Address</label>
                                <textarea id="current_address" name="current_address" class="form-control" placeholder="Enter Note"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parmanent_address" class="font-weight-bold text-dark" style="font-size: 14px;">Parmanent Address</label>
                                <textarea id="parmanent_address" name="parmanent_address" class="form-control" placeholder="Enter Note"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- Include Bonus Checkbox -->
                    <div class="form-group">
                        <div class="form-check" style="padding-left: 0px !important">
                            <input type="hidden" name="take_registration_fee" value="0">
                            <input class="form-check-input" type="checkbox" id="take_registration_fee" name="take_registration_fee" value="1">
                            <label class="form-check-label font-weight-bold text-dark" style="font-size: 14px;" for="take_registration_fee">
                                Take Registation fee
                            </label>
                        </div>
                    </div>
                   
                    <!-- Bonus Type -->
                    <div class="row">
                        <!-- Bonus Amount -->
                        <div class="form-group registation-fields col-md-4" style="display: none;">
                            <label for="registration_fee_amount" class="font-weight-bold text-dark" style="font-size: 14px;">Registation Fee</label>
                            <input type="number" id="registration_fee_amount" name="registration_fee_amount" class="form-control" placeholder="Enter Bonus Amount">
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="employeesSelect" class="font-weight-bold text-dark" style="font-size: 14px;">Referal By Employee</label>
                                <select name="employee_id" id="employeesSelect" class="form-control " required>
                                    <option value="" disabled selected>Select a Employee</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="branchSelect" class="font-weight-bold text-dark" style="font-size: 14px;">Select Branch Name</label>
                                <select name="branch_id" id="branchSelect" class="form-control " required>
                                    <option value="" disabled selected>Select a Branch</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="opening_balance" class="font-weight-bold text-dark" style="font-size: 14px;">Opening Balance</label>
                                <input type="number" id="opening_balance" name="opening_balance" class="form-control" placeholder="Enter First Name" required>
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="opening_balance_sheet" class="font-weight-bold text-dark" style="font-size: 14px;">Opening Balance Sheet</label>
                                 <input type="file" id="opening_balance_sheet" name="opening_balance_sheet" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="attachment" class="font-weight-bold text-dark" style="font-size: 14px;">Attachement</label>
                                 <input type="file" id="attachment" name="attachment" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="note" class="font-weight-bold text-dark" style="font-size: 14px;">Note</label>
                                <textarea id="note" name="note" class="form-control" placeholder="Enter Note"></textarea>
                            </div>
                        </div>
                    </div>


                    <div class="form-group form-check" style="padding-left: 0px !important">
                        <input type="checkbox" id="status" name="status" class="form-check-input" value="1" checked>
                        <label class="form-check-label" for="status">Active</label>
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
