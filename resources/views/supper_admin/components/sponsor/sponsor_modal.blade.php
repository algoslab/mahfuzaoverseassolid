<div class="modal fade" id="modal-center" tabindex="-1" aria-labelledby="modalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Manage Delegate</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- The Form -->
            <form id="sponsorForm">
                @csrf
                <input type="hidden" id="sponsor_id" name="sponsor_id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-700 font-size-16" for="sponsor_type">Sponsor Type</label>
                        <select name="sponsor_type" id="sponsor_type" class="form-control" required>
                            <option value="" disabled selected>Sponsor Type</option>
                            <option value="Agent">Agent</option>
                            <option value="Delegate">Delegate</option>
                            <option value="Prime Sponsor">Prime Sponsor</option>
                        </select>
                    </div>
                    <div class="form-group" id="agentDiv" style="display: none">
                        <label for="agent_id" class="font-weight-bold text-dark" style="font-size: 14px;">Choose Agent </label>
                        <select name="agent_id" id="agentSelect" class="form-control">
                            <option value="" disabled selected>Choose Agent</option>
                        </select>
                    </div>
                    <div class="form-group" id="delegateDiv" style="display: none">
                        <label for="delegate_id" class="font-weight-bold text-dark" style="font-size: 14px;">Choose Delegate </label>
                        <select name="delegate_id" id="delegateSelect" class="form-control">
                            <option value="" disabled selected>Choose Delegate</option>
                        </select>
                    </div>
                    <div class="form-group" id="delegateOfficeDiv" style="display: none">
                        <label for="delegate_office_id" class="font-weight-bold text-dark" style="font-size: 14px;">Delegate Office </label>
                        <select name="delegate_office_id" id="delegateOfficeSelect" class="form-control">
                            <option value="" disabled selected>Delegate Office</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="sponsor_name" class="font-weight-bold text-dark" style="font-size: 14px;">Sponsor Name</label>
                        <input type="text" id="sponsor_name" name="sponsor_name" class="form-control" placeholder="Sponsor Name" required>
                    </div>
                    <div class="form-group">
                        <label for="cell_number" class="font-weight-bold text-dark" style="font-size: 14px;">Cell No:</label>
                        <input type="text" id="cell_number" name="cell_number" class="form-control" placeholder="Cell No" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="font-weight-bold text-dark" style="font-size: 14px;">Email:</label>
                        <input type="text" id="email" name="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="form-group" id="openingBalanceDiv" style=display:none;>
                        <label for="opening_balance" class="font-weight-bold text-dark" style="font-size: 14px;">Opening Balance</label>
                        <input type="number" step="any" min="0" id="opening_balance" name="opening_balance" class="form-control form-control-lg" placeholder="Opening Balance">
                    </div>
                    <div class="form-group">
                        <label for="nid" class="font-weight-bold text-dark" style="font-size: 14px;">NID Number:</label>
                        <input type="text" id="nid" name="nid" class="form-control" placeholder="NID Number" required>
                    </div>
                    <div class="form-group">
                        <label for="sponsor_photo" class="font-weight-bold text-dark" style="font-size: 14px;">Sponsor Photo</label>
                        <input type="file" id="sponsor_photo" name="sponsor_photo" class="form-control" placeholder="Enter image" onchange="previewImage(event)">
                        <div id="imagePreviewContainer" style="margin-top: 10px;">
                            <img id="preview" src="" style="max-width: 100px; display: none;" />
                        </div>
                        <!-- Remove file toggle -->
                        <div id="remove-file-section" class="form-check mt-2 d-none">
                            <input type="checkbox" class="form-check-input" id="remove_file" name="remove_file" value="1">
                            <label class="form-check-label" for="remove_file">Remove existing file</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="font-weight-bold text-dark" style="font-size: 14px;">Address</label>
                        <textarea id="address" name="address" rows="2" cols="5" class="form-control form-control-lg"></textarea>
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



