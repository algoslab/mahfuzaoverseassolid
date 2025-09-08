<div class="modal fade" id="modal-center" tabindex="-1" aria-labelledby="modalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success p-4">
                <h5 class="modal-title" id="modalTitle">Add Delegate Office Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- The Form -->
            <form id="delegateOfficeForm" enctype="multipart/form-data" method="POST">
                @csrf
                <input type="hidden" id="delegate_office_id" name="delegate_office_id" value="">
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="delegateSelect" class="font-weight-bold text-dark" style="font-size: 14px;">Choose Delegate </label>
                                        <select name="delegate_id" id="delegateSelect" class="form-control select2" required>
                                            <option value="" disabled selected>Select a Delegate</option>
                                        </select>
                                    </div>
                                    
                                </div>
                                <input type="hidden" name="branch_id" id="delegate_branchId"  class="form-control" >
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="office_name" class="font-weight-bold text-dark" style="font-size: 14px;">Office Name</label>
                                        <input type="text" id="office_name" name="office_name" class="form-control" placeholder="Enter Office Name" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact_number" class="font-weight-bold text-dark" style="font-size: 14px;">Contact Number</label>
                                        <input type="number" id="contact_number" name="contact_number" class="form-control" placeholder="Enter Contact Name" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="licence_number" class="font-weight-bold text-dark" style="font-size: 14px;">Licence Number</label>
                                        <input type="number" id="licence_number" name="licence_number" class="form-control" placeholder="Enter First Name" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="attachment" class="font-weight-bold text-dark" style="font-size: 14px;">Attachment</label>
                                        <input type="file" id="attachment" name="attachment" class="form-control">
                                    </div>
                                </div>

                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address" class="font-weight-bold text-dark" style="font-size: 14px;">Office Address</label>
                                        <textarea id="address" name="address" class="form-control" placeholder="Enter Note"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="note" class="font-weight-bold text-dark" style="font-size: 14px;">Note</label>
                                        <textarea id="note" name="note" class="form-control" placeholder="Enter Note"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 bg-light">
                            <div class="container my-4 p-4 bg-white rounded shadow-sm">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="branding">
                                    ✈️ Mahfuza<span class="text-danger">O</span>verseas
                                </div>
                                <button class="btn btn-warning btn-sm btn-print" onclick="window.print()">🖨️ Print</button>
                                </div>
                                <!-- Profile Card -->
                                <div class="row card-info">
                                <div class="col-md-3 text-center">
                                    <img id="delegate_photo" class="img-fluid rounded" src="https://via.placeholder.com/130x100?text=Card" />
                                </div>
                                <div class="col-md-9">
                                    <div class="row mb-2">
                                    <div class="col-sm-3 info-label">Name</div>
                                    <div class="col-sm-9" id="delegate_name">:</div>
                                    </div>

                                    <div class="row mb-2">
                                    <div class="col-sm-3 info-label">Phone</div>
                                    <div class="col-sm-9" id="delegate_phone">: </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3 info-label">Email</div>
                                        <div class="col-sm-9 text-break" id="delegate_email">: </div>
                                    </div>
                                    <div class="row mb-2">
                                    <div class="col-sm-3 info-label">Country</div>
                                    <div class="col-sm-9" id="delegate_country">: </div>
                                    </div>
                                    <div class="row mb-2">
                                    <div class="col-sm-3 info-label">Address</div>
                                    <div class="col-sm-9" id="delegate_address">:</div>
                                    </div>
                                    <div class="row mb-2">
                                    <div class="col-sm-3 info-label">Balance</div>
                                    <div class="col-sm-9" id="delegate_balance">: </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
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
