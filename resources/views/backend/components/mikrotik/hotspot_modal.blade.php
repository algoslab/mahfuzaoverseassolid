<div class="modal fade" id="modal-center" tabindex="-1" aria-labelledby="modalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add hotspot</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- The Form -->
            <form id="hotspotFrom">
                @csrf
                <input type="hidden" id="hotspot_id" name="hotspot_id" value="">
            
                <div class="modal-body">
                    <div class="form-group">
                        <label for="branchSelect" class="font-weight-bold text-dark" style="font-size: 14px;">Select Branch</label>
                        <select name="branch_id" id="branchSelect" class="form-control select2" required>
                            <option value="" disabled selected>Select a Branch</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="routerSelect" class="font-weight-bold text-dark" style="font-size: 14px;">Select Router</label>
                        <select name="mikrotik_device_id" id="routerSelect" class="form-control select2" required>
                            <option value="" disabled selected>Select a Router</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="profile" class="font-weight-bold text-dark" style="font-size: 14px;">profile No</label>
                        <input type="text" id="profile" name="profile" class="form-control" value="default" readonly placeholder="Enter Network Address">
                    </div>
            
                    <div class="form-group">
                        <label for="username" class="font-weight-bold text-dark" style="font-size: 14px;">Username</label>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Enter Username" required>
                    </div>
            
                    <div class="form-group">
                        <label for="password" class="font-weight-bold text-dark" style="font-size: 14px;">Password</label>
                        <input type="text" id="password" name="password" class="form-control" placeholder="Enter Password" required>
                    </div>
            
                    <div class="form-group form-check">
                        <input type="checkbox" id="status" name="status" class="form-check-input" value="1" checked>
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



