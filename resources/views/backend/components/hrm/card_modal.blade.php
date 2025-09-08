<div class="modal fade" id="modal-card" tabindex="-1" aria-labelledby="modalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Card Form (<span class="text-danger" id="employeeName"></span>)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- The Form -->
            <form id="accessCardForm" enctype="multipart/form-data" method="POST">
                @csrf
                <input type="hidden" id="employee_id" name="employee_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="current_cardnumber" class="font-weight-bold text-dark" style="font-size: 14px;">Current Access Number</label>
                        <input type="text" id="current_cardnumber" class="form-control" placeholder="Enter Card number" readonly>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="cardnumber" class="font-weight-bold text-dark" style="font-size: 14px;">Add New Access Number</label>
                        <input type="text" id="cardnumber" name="access_card" class="form-control" placeholder="Enter Card number" required>
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
