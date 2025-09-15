<div class="modal fade" id="candidateTransactionModal" tabindex="-1" role="dialog" aria-labelledby="candidateTransactionModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="candidateTransactionForm" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="candidate_id" id="transaction_candidate_id">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="candidateTransactionModalLabel">Make Transaction</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-6">
              <label>Transaction Type</label>
              <select name="transaction_type" class="form-control select2">
                <option value="">--Select one--</option>
                <option value="Recieved Payment">Recieved Payment</option>
                <option value="Give Payment">Give Payment</option>
                <option value="Income">Income</option>
                <option value="Expense">Expense</option>
              </select>
            </div>
            <div class="form-group  col-md-6">
              <label>Transaction Purpose</label>
              <select name="transaction_purpose" class="form-control select2">
                <option value="">--Select one--</option>
                @foreach($transactionPurposes as $key => $value)
                  <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-6">
              <label>Payment Method</label>
              <select name="payment_method" class="form-control select2">
                <option value="">--Select one--</option>
                <option value="Bank Account">Bank Account</option>
                <option value="Cash In Hand">Cash In Hand</option>
                <option value="Mobile Banking">Mobile Banking</option>
                <option value="Office Assets">Office Assets</option>
              </select>
            </div>
            <div class="form-group  col-md-6">
              <label>
                Currency
                <span id="currency_rate_info" class="text-danger small font-weight-bold"></span>
              </label>
              <select name="currency" class="form-control select2" id="currency_select">
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
          </div>
          <div class="row">
            <div class="form-group col-md-6">
              <label>Amount</label>
              <input type="number" step="0.01" name="amount" class="form-control" id="amount" placeholder="Amount">
            </div>
            <div class="form-group  col-md-6">
              <label>BDT Amount</label>
              <input type="number" value="0.00" step="0.01" name="amount_bdt" class="form-control" id="amount_bdt" readonly>
            </div>
          </div>
          <div class="form-group">
            <label>Attachment (If need!)</label>
            <input type="file" name="attachment" class="form-control">
          </div>
          <div class="form-group">
            <label>Transaction Note</label>
            <textarea name="transaction_note" class="form-control" placeholder="Transaction Note"></textarea>
          </div>
          <div class="form-group">
            <label>Note</label>
            <textarea name="note" class="form-control" placeholder="Note"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-md btn-primary">Save Transaction</button>
        </div>
      </div>
    </form>
  </div>
</div> 