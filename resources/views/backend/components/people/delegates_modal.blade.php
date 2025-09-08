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
            <form id="delegateForm" enctype="multipart/form-data" method="POST">
                @csrf
                <input type="hidden" id="delegate_id" name="delegate_id" value="">
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
                                <label for="delegate_photo" class="font-weight-bold text-dark" style="font-size: 14px;">Delegate Photo</label>
                                 <input type="file" id="delegate_photo" name="delegate_photo" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Select Country </label>
                                <select name="country_id" id="countriesSelect" class="form-control select2" required>
                                    <option value="" disabled selected>Select a Country</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="state" class="font-weight-bold text-dark" style="font-size: 14px;">State</label>
                                 <input type="text" id="state" name="state" class="form-control">
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="sponsor_type" class="font-weight-bold text-dark" style="font-size: 14px;">
                                Reference Type
                            </label>
                            <select name="sponsor_type" id="sponsor_type" class="form-control">
                                <option value="agent">Agent</option>
                                <option value="employee">Employee</option>
                                <option value="prime_sponsor" selected>Prime Reference</option>
                            </select>
                        </div>


                        <div class="form-group col-md-4 type-field type-agent" style="display: none;">
                            <label for="agentSelect" class="font-weight-bold text-dark" style="font-size: 14px;">Referral By Employee</label>
                            <select name="agent_id" id="agentSelect" class="form-control select2">
                                <option value="" disabled selected>Select an Agent</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4 type-field type-employee" style="display: none;">
                            <label for="employeesSelect" class="font-weight-bold text-dark" style="font-size: 14px;">Referral By Employee</label>
                            <select name="employee_id" id="employeesSelect" class="form-control select2">
                                <option value="" disabled selected>Select an Employee</option>
                            </select>
                        </div>

                    </div>

                    <!-- Include Bonus Checkbox -->


                   
                    <!-- Bonus Type -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="branchSelect" class="font-weight-bold text-dark" style="font-size: 14px;">Select Branch Name</label>
                                <select name="branch_id" id="branchSelect" class="form-control select2" required>
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

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="current_address" class="font-weight-bold text-dark" style="font-size: 14px;">Current Address</label>
                                <textarea id="current_address" name="current_address" class="form-control" placeholder="Enter Note"></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
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
