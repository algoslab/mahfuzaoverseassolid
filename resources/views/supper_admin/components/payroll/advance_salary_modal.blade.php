<div class="modal fade" id="modal-center" tabindex="-1" aria-labelledby="modalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Advance Salary</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- The Form -->
            <form id="advanceSalaryForm">
                @csrf
                <input type="hidden" id="performance_bonus_id" name="performance_bonus_id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="department_id" class="font-weight-bold text-dark" style="font-size: 14px;">Choose Department </label>
                        <select name="department_id" id="departmentSelect" class="form-control" required>
                            <option value="" disabled selected>Choose Department</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="employee_id" class="font-weight-bold text-dark" style="font-size: 14px;">Choose Employee </label>
                        <select name="employee_id" id="employeeSelect" class="form-control" required>
                            <option value="" disabled selected>Choose Employee</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="month" class="font-weight-bold text-dark" style="font-size: 14px;">Month</label>
                        <input type="month" id="month" name="month" class="form-control" placeholder="Month">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-700 font-size-16" for="payment_account">Payment Account</label>
                        <select name="payment_account" id="payment_account" class="form-control" required>
                            <option value="" disabled selected>Payment Method</option>
                            <option value="Bank Account">Bank Account</option>
                            <option value="Cash in Hand">Cash in Hand</option>
                            <option value="Mobile Banking">Mobile Banking</option>
                            <option value="Office Assets">Office Assets</option>
                        </select>
                    </div>
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
                    </div>
                    <div class="form-group">
                        <label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Amount<small id="amount_currency"></small></label>
                        <input type="number" step="any" min="0" id="amount" name="amount" class="form-control" placeholder="Amount" required>
                    </div>
                    <div class="row">
                        <div class="col-sm-12" id="amount_translate">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="salary" class="font-weight-bold text-dark" style="font-size: 14px;">BDT Amount</label>
                        <input type="number" id="bdt_amount" name="bdt_amount" class="form-control" placeholder="BDT Amount" required readonly style="color: #ff0000">
                    </div>
                    <div class="form-group">
                        <label for="opening_balance_sheet" class="font-weight-bold text-dark" style="font-size: 14px;">Attachment(If needed)</label>
                        <input type="file" id="attachment" name="attachment" class="form-control form-control-lg">
                    </div>

                    <div class="form-group">
                        <label for="note" class="font-weight-bold text-dark" style="font-size: 14px;">Note</label>
                        <textarea id="note" name="note" rows="2" cols="5" class="form-control form-control-lg"></textarea>
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



