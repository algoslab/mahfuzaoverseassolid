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
            <form id="macForm">
                @csrf
                <input type="hidden" id="mac_address_id" name="mac_address_id" value="">
            
                <div class="modal-body">
                    <div class="form-group">
                        <label for="branchSelect" class="font-weight-bold text-dark" style="font-size: 14px;">Select Branch</label>
                        <select name="branch_id" id="branchSelect" class="form-control select2" required>
                            <option value="" disabled selected>Select a Branch</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="routerSelect" class="font-weight-bold text-dark" style="font-size: 14px;">Select Router</label>
                        <select name="mikrotik_device_id" id="routerSelect" class="form-control" required>
                            <option value="" disabled selected>Select a Router</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="type" class="font-weight-bold text-dark" style="font-size: 14px;">Mac Type</label>
                        <select id="type" name="type" class="form-control">
                            <option value="bypassed" selected>Bypassed</option>
                            <option value="blocked">Blocked</option>
                            <option value="regular">Regular</option>
                        </select>
                    </div>
        
                        <div class="form-group">
                            <label class="font-weight-bold text-dark" style="font-size: 14px;">Select Type</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="address_type" id="mac_option" value="mac" checked>
                                <label class="form-check-label" for="mac_option">MAC Address</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="address_type" id="ip_option" value="ip">
                                <label class="form-check-label" for="ip_option">IP Address</label>
                            </div>
                        </div>

                        <div class="form-group" id="mac_address_group">
                            <label for="mac_address" class="font-weight-bold text-dark" style="font-size: 14px;">MAC Address</label>
                            <input type="text" id="mac_address" name="mac_address" class="form-control" placeholder="Enter MAC Address">
                        </div>

                        <div class="form-group d-none" id="ip_address_group">
                            <label for="ip_address" class="font-weight-bold text-dark" style="font-size: 14px;">IP Address</label>
                            <input type="text" id="ip_address" name="ip_address" class="form-control" placeholder="Enter IP Address">
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



