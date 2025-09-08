<div class="modal fade" id="modal-finger" tabindex="-1" aria-labelledby="modalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Finger Form (<span class="text-danger" id="employeeName1"></span>)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- The Form -->
            <form id="fingerForm" enctype="multipart/form-data" method="POST">
                @csrf
                <input type="hidden" id="employee_id" name="employee_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="add_finger" class="font-weight-bold text-dark" style="font-size: 14px;">Add Finger</label>
                        <input type="text" id="add_finger" name="add_finger" class="form-control" placeholder="Enter Finger number" required>
                    </div>

                    <div class="form-group form-check">
                        <input type="checkbox" id="is_active_finger" name="is_active_finger" class="form-check-input" value="1" checked>
                        <label class="form-check-label" for="is_active_finger">Active</label>
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
