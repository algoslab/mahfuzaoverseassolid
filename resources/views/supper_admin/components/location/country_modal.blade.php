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
            <form id="countryForm">
                @csrf
                <input type="hidden" id="country_id" name="country_id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Select Continent </label>
                        <select name="continent_id" id="continentSelect" class="form-control" required>
                            <option value="" disabled selected>Select a Continent</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter Country Name" required>
                    </div>
                    <div class="form-group">
                        <label for="country_code" class="font-weight-bold text-dark" style="font-size: 14px;">Country Code</label>
                        <input type="text" id="country_code" name="country_code" class="form-control" placeholder="Enter Country Code" required maxlength="2" pattern="[A-Za-z]{2}">
                        <small class="form-text text-muted">Please enter a two-character code for the Country.</small>
                    </div>
                    <div class="form-group">
                        <label for="phone_code" class="font-weight-bold text-dark" style="font-size: 14px;">Phone Code</label>
                        <input type="text" id="phone_code" name="phone_code" class="form-control" placeholder="Enter Phone Code" required maxlength="4" required pattern="^\+?[1-9]\d{1,14}$">
                        <small class="form-text text-muted">Please enter a valid phone code (e.g., +1 for the USA).</small>
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



