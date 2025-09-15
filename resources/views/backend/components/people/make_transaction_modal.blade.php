<div class="modal fade" id="makeTransactionModal" tabindex="-1" aria-labelledby="makeTransactionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="makeTransactionModalLabel">Make Transaction</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="makeTransactionForm" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="transaction_type" class="form-label">Transaction Type</label>
              <select class="form-select" id="transaction_type" name="transaction_type" required>
                <option value="">Select Type</option>
                <!-- Options dynamically loaded -->
              </select>
            </div>
            <div class="col-md-6">
              <label for="payment_method" class="form-label">Payment Method</label>
              <select class="form-select" id="payment_method" name="payment_method" required>
                <option value="">Select Method</option>
                <!-- Options dynamically loaded -->
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="currency" class="form-label">Currency</label>
              <select class="form-select" id="currency" name="currency" required>
                <option value="">Select Currency</option>
                <!-- Options dynamically loaded -->
              </select>
            </div>
            <div class="col-md-6">
              <label for="amount" class="form-label">Amount</label>
              <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="bdt_amount" class="form-label">BDT Amount</label>
              <input type="number" step="0.01" class="form-control" id="bdt_amount" name="bdt_amount" readonly>
            </div>
            <div class="col-md-6">
              <label for="candidate_id" class="form-label">Care/of Candidate (If need!)</label>
              <select class="form-select" id="candidate_id" name="candidate_id">
                <option value="">Select Candidate</option>
                <!-- Options dynamically loaded -->
              </select>
            </div>
          </div>
          <div class="mb-3">
            <label for="attachment" class="form-label">Attachment (If need!)</label>
            <input type="file" class="form-control" id="attachment" name="attachment">
          </div>
          <div class="mb-3">
            <label for="transaction_note" class="form-label">Transaction note</label>
            <textarea class="form-control" id="transaction_note" name="transaction_note" rows="2"></textarea>
          </div>
          <div class="mb-3">
            <label for="note" class="form-label">Note</label>
            <textarea class="form-control" id="note" name="note" rows="2"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div> 