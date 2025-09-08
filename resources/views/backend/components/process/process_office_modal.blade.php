<div class="modal fade" id="modal-center" tabindex="-1" aria-labelledby="modalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Agency and Processing Office</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- The Form -->
            <form id="ProcessOfficesForm" enctype="multipart/form-data" method="POST">
                @csrf
                <input type="hidden" id="process_office_id" name="process_office_id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Agency or Office Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter Category Name" required>
                    </div>

                    <div class="form-group">
                        <label for="license_number" class="font-weight-bold text-dark" style="font-size: 14px;">License Number</label>
                        <input type="text" id="license_number" name="license_number" class="form-control" placeholder="Enter Category Name" required>
                    </div>

                    <div class="form-group">
                        <label for="email" class="font-weight-bold text-dark" style="font-size: 14px;">Email</label>
                        <input type="text" id="email" name="email" class="form-control" placeholder="Enter Category Name" required>
                    </div>

                    <div class="form-group">
                        <label for="phone_number" class="font-weight-bold text-dark" style="font-size: 14px;">Phone Number</label>
                        <input type="number" id="phone_number" name="phone_number" class="form-control" placeholder="Enter Category Name" required>
                    </div>

                    <div class="form-group">
                        <label for="opening_balance" class="font-weight-bold text-dark" style="font-size: 14px;">Opening Balance</label>
                        <input type="number" id="opening_balance" name="opening_balance" class="form-control" placeholder="Enter Category Name" required>
                    </div>

                    <div class="form-group">
                        <label for="address" class="font-weight-bold text-dark" style="font-size: 14px;">Address</label>
                        <textarea id="address" name="address" class="form-control" placeholder="Enter address"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="office_pad" class="font-weight-bold text-dark" style="font-size: 14px;">Office Pad</label>
                        <input type="file" id="office_pad" name="office_pad" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="opening_balance_sheet" class="font-weight-bold text-dark" style="font-size: 14px;">Opening Balance Sheet</label>
                        <input type="file" id="opening_balance_sheet" name="opening_balance_sheet" class="form-control">
                    </div>



                    <div class="form-group">
                        <label for="note" class="font-weight-bold text-dark" style="font-size: 14px;">Note</label>
                        <textarea id="note" name="note" class="form-control" placeholder="Enter Note"></textarea>
                    </div>
                    <div class="form-group form-check" style="padding-left: 0px !important">
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
