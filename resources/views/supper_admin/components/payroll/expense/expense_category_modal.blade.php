<div class="modal fade" id="modal-center" tabindex="-1" aria-labelledby="modalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Expense Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- The Form -->
            <form id="expenseCategoryForm">
                @csrf
                <input type="hidden" id="expense_category_id" name="expense_category_id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-700 font-size-16" for="account_type">Choose Account Type</label>
                        <select name="account_type" id="account_type" class="form-control">
                            <option value="" disabled selected>Account Type</option>
                            <option value="Assets">Assets</option>
                            <option value="Expense">Expense</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="expense_category_name" class="font-weight-bold text-dark" style="font-size: 14px;">Expense Category Name</label>
                        <input type="text" id="expense_category_name" name="expense_category_name" class="form-control" placeholder="Expense Category Name" required>
                    </div>
                    <div class="form-group">
                        <label for="expense_category_code" class="font-weight-bold text-dark" style="font-size: 14px;">Expense Category Code</label>
                        <input type="text" id="expense_category_code" name="expense_category_code" class="form-control form-control-lg" placeholder="Expense Category Code" required>
                    </div>
                    <div class="form-group">
                        <label for="opening_balance" class="font-weight-bold text-dark" style="font-size: 14px;">Opening Balance</label>
                        <input type="number" step="any" min="0" id="opening_balance" name="opening_balance" class="form-control form-control-lg" placeholder="Opening Balance">
                    </div>
                    <div class="form-group">
                        <label for="opening_balance_sheet" class="font-weight-bold text-dark" style="font-size: 14px;">Opening Balance Sheet</label>
                        <input type="file" id="opening_balance_sheet" name="opening_balance_sheet" class="form-control form-control-lg">
                        <!-- Existing file preview -->
                        <div id="existing-file-preview" style="margin-top: 10px;"></div>

                        <!-- Remove file toggle -->
                        <div id="remove-file-section" class="form-check mt-2 d-none">
                            <input type="checkbox" class="form-check-input" id="remove_file" name="remove_file" value="1">
                            <label class="form-check-label" for="remove_file">Remove existing file</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="note" class="font-weight-bold text-dark" style="font-size: 14px;">Note</label>
                        <textarea id="note" name="note" rows="2" cols="5" class="form-control form-control-lg"></textarea>
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
