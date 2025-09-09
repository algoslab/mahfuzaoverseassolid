<div class="modal fade" id="modal-center" tabindex="-1" aria-labelledby="modalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Country</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- The Form -->
            <form id="expenseItemForm">
                @csrf
                <input type="hidden" id="expense_item_id" name="expense_item_id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Expense Category </label>
                        <select name="expense_category_id" id="categorySelect" class="form-control" required>
                            <option value="" disabled selected>Choose Category</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="expense_item_name" class="font-weight-bold text-dark" style="font-size: 14px;">Expense Item name</label>
                        <input type="text" id="expense_item_name" name="expense_item_name" class="form-control" placeholder="Expense Item name" required>
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



