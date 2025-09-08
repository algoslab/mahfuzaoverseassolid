<div class="modal fade" id="modal-center" tabindex="-1" aria-labelledby="modalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Work Permit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- The Form -->
            <form id="workpermitForm">
                @csrf
                <input type="hidden" id="work_permit_id" name="work_permit_id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="expire_date" class="font-weight-bold text-dark" style="font-size: 14px;">Expire Date</label>
                        <input type="date" id="expire_date" name="expire_date" class="form-control" placeholder="Enter salary" required>
                    </div>
                    <div class="form-group">
                        <label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Select Continent </label>
                        <select name="continent_id" id="continentSelect" class="form-control" required>
                            <option value="" disabled selected>Select a Continent</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Select Country </label>
                        <select name="country_id" id="countriesSelect" class="form-control" required>
                            <option value="" disabled selected>Select a Country</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Job Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter Country Name" required>
                    </div>
                    <div class="form-group">
                        <label for="salary" class="font-weight-bold text-dark" style="font-size: 14px;">Salary</label>
                        <input type="number" id="salary" name="salary" class="form-control" placeholder="Enter salary" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="code" class="font-weight-bold text-dark" style="font-size: 14px;">Code</label>
                        <input type="text" id="code" name="code" class="form-control" placeholder="Enter Work Permit Code" required>
                    </div>

                    <div class="form-group">
                        <label for="image" class="font-weight-bold text-dark" style="font-size: 14px;">Poster</label>
                        <input type="file" id="image" name="image" class="form-control" placeholder="Enter image" onchange="previewImage(event)">
                        <div id="imagePreviewContainer" style="margin-top: 10px;">
                            <img id="preview" src="" style="max-width: 100px; display: none;" />
                        </div>
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



