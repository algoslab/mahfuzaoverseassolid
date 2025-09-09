<div class="modal fade" id="modal-center" tabindex="-1" aria-labelledby="modalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Festival Bonus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- The Form -->
            <form id="festivalBonusForm">
                @csrf
                <input type="hidden" id="festival_bonus_id" name="festival_bonus_id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="month" class="font-weight-bold text-dark" style="font-size: 14px;">Select Month</label>
                        <input type="month" id="month" name="month" class="form-control" placeholder="Month">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-700 font-size-16" for="amount_type">Amount Type</label>
                        <select name="amount_type" id="amount_type" class="form-control" required>
                            <option value="" disabled selected>Amount Type</option>
                            <option value="Percentage">Percentage</option>
                            <option value="Fixed">Fixed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount" class="font-weight-bold text-dark" style="font-size: 14px;">Amount<small id="amount_currency"></small></label>
                        <input type="number" step="any" min="0" id="amount" name="amount" class="form-control" placeholder="Amount" required>
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



