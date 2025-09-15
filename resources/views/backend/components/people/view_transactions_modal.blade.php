<div class="modal fade" id="viewTransactionsModal" tabindex="-1" aria-labelledby="viewTransactionsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewTransactionsModalLabel">Investor Transactions</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-striped" id="transactionsTable">
          <thead>
            <tr>
              <th>#</th>
              <th>Transaction Type</th>
              <th>Payment Method</th>
              <th>Currency</th>
              <th>Amount</th>
              <th>BDT Amount</th>
              <th>Candidate</th>
              <th>Attachment</th>
              <th>Transaction Note</th>
              <th>Note</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <!-- Transactions dynamically loaded via JS -->
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> 