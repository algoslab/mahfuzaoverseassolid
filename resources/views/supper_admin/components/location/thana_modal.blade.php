<div class="modal fade" id="modal-center" tabindex="-1" aria-labelledby="modalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Thana</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- The Form -->
            <form id="thanaFrom">
                @csrf
                <input type="hidden" id="thana_id" name="thana_id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Select District </label>
                        <select name="district_id" id="districtSelect" class="form-control" required>
                            <option value="" disabled selected>Select a District</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter Country Name" required>
                    </div>
                    <div class="form-group">
                        <label for="code" class="font-weight-bold text-dark" style="font-size: 14px;">Thana Code</label>
                        <input type="text" id="code" name="code" class="form-control" placeholder="Enter Division Code" required maxlength="3" pattern="[A-Za-z]{3}">
                        <small class="form-text text-muted">Please enter a two-character code for the Thana.</small>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" id="status" name="status" class="form-check-input" value="Active" checked>
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



