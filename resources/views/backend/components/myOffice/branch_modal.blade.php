<div class="modal fade" id="modal-center" tabindex="-1" aria-labelledby="modalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Branch</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- The Form -->
            <form id="branchFrom" enctype="multipart/form-data" method="POST">
                @csrf
                <input type="hidden" id="branch_id" name="branch_id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter Branch Name" required>
                    </div>

                    <div class="form-group">
                        <label for="code" class="font-weight-bold text-dark" style="font-size: 14px;">Branch Code</label>
                        <input type="text" id="code" name="code" class="form-control" placeholder="Enter Branch Code">
                    </div>
                    <div class="form-group">
                        <label for="phone" class="font-weight-bold text-dark" style="font-size: 14px;">Contact Number</label>
                        <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter Contact Number">
                    </div>
                    <div class="form-group">
                        <label for="email" class="font-weight-bold text-dark" style="font-size: 14px;">Branch Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter Branch Email">
                    </div>

                    <div class="form-group">
                        <label for="address" class="font-weight-bold text-dark" style="font-size: 14px;">Branch Address</label>
                        <input type="text" id="address" name="address" class="form-control" placeholder="Enter Branch Address">
                    </div>
                    <div class="form-group">
                        <label for="note" class="font-weight-bold text-dark" style="font-size: 14px;">Note</label>
                        <textarea id="note" name="note" class="form-control" placeholder="Enter Note"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="picture" class="font-weight-bold text-dark" style="font-size: 14px;">Branch Picture</label>
                        <input type="file" name="picture" id="picture" class="form-control">
                        <img id="existing-picture" src="" alt="Current Picture" width="100" style="display:none;">                   
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
