<div class="modal fade" id="modal-center" tabindex="-1" aria-labelledby="modalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Performance Bonus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- The Form -->
            <form id="incAndDecForm">
                @csrf
                <input type="hidden" id="inc_and_dec_id" name="inc_and_dec_id" value="">
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
                        <label class="font-weight-700 font-size-16" for="impression_type">Impression Type</label>
                        <select name="impression_type" id="impression_type" class="form-control" required>
                            <option value="" disabled selected>Impression Type</option>
                            <option value="Increment">Increment</option>
                            <option value="Decrement">Decrement</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="start_month" class="font-weight-bold text-dark" style="font-size: 14px;">Start Month</label>
                        <input type="month" id="start_month" name="start_month" class="form-control" placeholder="Month">
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



