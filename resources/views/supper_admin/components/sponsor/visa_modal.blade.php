<div class="modal fade" id="modal-center" tabindex="-1" aria-labelledby="modalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Manage Visa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- The Form -->
            <form id="visaForm">
                @csrf
                <input type="hidden" id="visa_id" name="visa_id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Choose Sponsor</label>
                        <select name="sponsor_id" id="sponsorSelect" class="form-control">
                            <option value="" disabled selected>Choose Sponsor</option>
                        </select>
                        </div>
                    <div class="form-group">
                        <label>Choose Job</label>
                        <select name="job_list_id" id="jobSelect" class="form-control">
                            <option value="" disabled selected>Choose Job</option>
                        </select>
                    </div>
                    <div class="form-group">

                    </div>
                    <div class="row">
                        <div class="col-sm-12 all_country_checkbox_container">
                            <div class="form-group">
                                <label>Country</label>
                                <select name="country_id" id="countrySelect" class="form-control">
                                    <option value="" disabled selected>Country</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6" style="display:none;">
                            <div class="form-group">
                                <label>Issue Date</label>
                                <input type="date" name="issue_date" id="issue_date" autocomplete="off" placeholder="Choose Issue Date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Age from</label>
                                <input type="number" step="1" name="age_from" value="18" id="age_from" placeholder="Age from" class="form-control" required>
                            </div>
                            <div class="col-sm-6">
                                <label>Age to</label>
                                <input type="number" step="1" name="age_to" id="age_to" value="70" placeholder="Age to" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6" style="display:none;">
                            <div class="form-group">
                                <label>Visa Number</label>
                                <input type="text" name="visa_number" id="visa_number" placeholder="Visa Number/Code" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Visa Quantity</label>
                                <input type="number" step="any" name="visa_qty" id="visa_qty" placeholder="Visa Quantity" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6" style="display:none;">
                            <div class="form-group">
                                <label>Choose Type</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="" disabled selected>Choose Type</option>
                                    <option value="Air Ticket">Air Ticket</option>
                                    <option value="Business Visa">Business Visa</option>
                                    <option value="Hazz & Umr.ah">Hazz & Umrah</option>
                                    <option value="Manpower">Manpower</option>
                                    <option value="Patient">Patient</option>
                                    <option value="Tourist">Tourist</option>
                                    <option value="Visa Processing">Visa Processing</option>
                                    <option value="Worker">Worker</option>
                                </select>
                                 </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Choose Gender</label>
                                <select name="gender" id="gender" class="form-control" required>
                                    <option value="" disabled selected>Choose Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Haji">Haji</option>
                                </select> </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                               <label for="currency_id" class="font-weight-bold text-dark" style="font-size: 14px;">Currency <span id="currency_rate_info" class="text-danger small font-weight-bold"></span></label>
                                <select name="currency" class="form-control select2" id="currency_select" required>
                                    <option value="">--Select one--</option>
                                    <option value="AFN">Afghanistan - Afghanis (AFN)</option>
                                    <option value="ALL">Albania - Leke (ALL)</option>
                                    <option value="USD">American Samoa - Dollars (USD)</option>
                                    <option value="ARS">Argentina - Pesos (ARS)</option>
                                    <option value="AWG">Aruba - Guilders (AWG)</option>
                                    <option value="AUD">Australia - Dollars (AUD)</option>
                                    <option value="AZN">Azerbaijan - New Manats (AZN)</option>
                                    <option value="BSD">Bahamas - Dollars (BSD)</option>
                                    <option value="BDT">Bangladesh - Taka (BDT)</option>
                                    <option value="BBD">Barbados - Dollars (BBD)</option>
                                    <option value="EUR">Belgium - Euro (EUR)</option>
                                    <option value="BZD">Belize - Dollars (BZD)</option>
                                    <option value="BMD">Bermuda - Dollars (BMD)</option>
                                    <option value="BOB">Bolivia - Bolivianos (BOB)</option>
                                    <option value="BAM">Bosnia and Herzegovina - Convertible Marka (BAM)</option>
                                    <option value="BWP">Botswana - Pula (BWP)</option>
                                    <option value="BRL">Brazil - Reais (BRL)</option>
                                    <option value="BND">Brunei Darussalam - Dollars (BND)</option>
                                    <option value="BGN">Bulgaria - Leva (BGN)</option>
                                    <option value="KHR">Cambodia - Riels (KHR)</option>
                                    <option value="XCD">Cameroon - Dollars (XCD)</option>
                                    <option value="CAD">Canada - Dollars (CAD)</option>
                                    <option value="KYD">Cayman Islands - Dollars (KYD)</option>
                                    <option value="CLP">Chile - Pesos (CLP)</option>
                                    <option value="CNY">China - Yuan Renminbi (CNY)</option>
                                    <option value="COP">Colombia - Pesos (COP)</option>
                                    <option value="CRC">Costa Rica - Colón (CRC)</option>
                                    <option value="HRK">Croatia - Kuna (HRK)</option>
                                    <option value="CUP">Cuba - Pesos (CUP)</option>
                                    <option value="EUR">Cyprus - Euro (EUR)</option>
                                    <option value="CZK">Czech Republic - Koruny (CZK)</option>
                                    <option value="DKK">Denmark - Kroner (DKK)</option>
                                    <option value="DOP">Dominican Republic - Pesos (DOP)</option>
                                    <option value="EGP">Egypt - Pounds (EGP)</option>
                                    <option value="SVC">El Salvador - Colones (SVC)</option>
                                    <option value="FKP">Falkland Islands (Malvinas) - Pounds (FKP)</option>
                                    <option value="EUR">France - Euro (EUR)</option>
                                    <option value="EUR">Greece - Euro (EUR)</option>
                                    <option value="EUR">Holy See (Vatican City State) - Euro (EUR)</option>
                                    <option value="INR">India - Rupees (INR)</option>
                                    <option value="EUR">Ireland - Euro (EUR)</option>
                                    <option value="EUR">Italy - Euro (EUR)</option>
                                    <option value="JPY">Japan - Yen (JPY)</option>
                                    <option value="JOD">Jordan - Dinar (JOD)</option>
                                    <option value="EUR">Luxembourg - Euro (EUR)</option>
                                    <option value="MYR">Malaysia - Ringgits (MYR)</option>
                                    <option value="EUR">Malta - Euro (EUR)</option>
                                    <option value="EUR">Netherlands - Euro (EUR)</option>
                                    <option value="OMR">Oman - Rials (OMR)</option>
                                    <option value="EUR">Reunion - Euro (EUR)</option>
                                </select>
                                <input type="hidden" name="bdt_price" id="bdt_price" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row" style="display:none;">
                        <div class="col-sm-12" style="border: solid 2px #d9d9d9;padding-top: 10px;border-radius: 15px;">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="salary_currency_id" class="font-weight-bold text-dark" style="font-size: 14px;">Currency <small id="salary_currency_details" style="color: #ff0000"></small></label>
                                            <select name="salary_currency_id" id="salaryCurrencySelect" class="form-control">
                                                <option value="" disabled selected>Choose Currency</option>
                                            </select>
                                        </div>
                                        <input type="hidden" name="salary_bdt_amount" id="salary_bdt_amount" value="">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Monthly Salary</label>
                                        <input type="number" step="any" name="monthly_salary" id="monthly_salary" placeholder="Monthly Salary" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row payment_type_container" id="purchase_div_prev">
                        <div class="col-sm-12" style="border: solid 2px #d9d9d9;padding-top: 10px;border-radius: 15px;margin-bottom: 10px;margin-top: 10px;">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Purchase Amount</label>
                                        <input type="number" step="any" name="purchase_amount" id="purchase_amount" placeholder="Amount/Cost" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Payment Type</label>
                                        <select name="payment_type" id="payment_type" class="form-control">
                                            <option value="" disabled selected>Payment Type</option>
                                            <option value="Free">Free</option>
                                            <option value="Due">Due</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row agent_candidate_price_container">
                        <div class="col-sm-12" style="border: solid 2px #d9d9d9;padding-top: 10px;border-radius: 15px;margin-bottom: 10px;">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Agent Price </label>
                                        <input type="number" step="any" name="agent_price" id="agent_price" placeholder="Agent Sell Amount" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Candidate Price </label>
                                        <input type="number" step="any" name="candidate_price" id="candidate_price" placeholder="Candidate Sell Amount" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-6" id="commission_div" style="display: none">
                                    <div class="form-group">
                                        <label>Commission Amount </label>
                                        <input type="number" step="any" name="commission_amount" id="commission_amount" placeholder="Commission Amount" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Demand Latter <span class="demand_latter"></span></label>
                                <input type="file" id="demand_latter" style="padding: 3px;" name="demand_latter" class="form-control">
                                <!-- Existing file preview -->
                                <div id="existing-file-preview1" style="margin-top: 10px;"></div>

                                <!-- Remove file toggle -->
                                <div id="remove-file-section1" class="form-check mt-2 d-none">
                                    <input type="checkbox" class="form-check-input" id="remove_file11" name="remove_file" value="1">
                                    <label class="form-check-label" for="remove_file1">Remove existing file</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
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
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Note</label>
                        <textarea name="note" class="form-control" placeholder="Note"></textarea>
                    </div>
                    <div class="form-group" style="display:none;">
                        <div class="checkbox checkbox-success">
                            <input name="provide_food" id="provide_food" type="checkbox">
                            <label for="provide_food"> Food will be provided </label>
                        </div>
                    </div>
                    <div class="form-group" style="display:none;">
                        <div class="checkbox checkbox-success">
                            <input name="provide_accommodation" id="provide_accommodation" type="checkbox">
                            <label for="provide_accommodation"> Accommodation will be provided </label>
                        </div>
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



