<div class="modal fade" id="modal-center" tabindex="-1" aria-labelledby="modalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- The Form -->
            <form id="departmentFrom" enctype="multipart/form-data" method="POST">
                @csrf
                <input type="hidden" id="department_id" name="department_id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Department Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter Department Name" required>
                    </div>
                    <div class="form-group">
                        <label for="code" class="font-weight-bold text-dark" style="font-size: 14px;">Department Code</label>
                        <input type="text" id="code" name="code" class="form-control" placeholder="Enter Department Code">
                    </div>
                    <!-- Include Bonus Checkbox -->
                    <div class="form-group">
                        <div class="form-check" style="padding-left: 0px !important">
                            <input type="hidden" name="include_status" value="0">
                            <input class="form-check-input" type="checkbox" id="include_status" name="include_status" value="1">
                            <label class="form-check-label font-weight-bold text-dark" style="font-size: 14px;" for="include_status">
                                Include Attendance Bonus
                            </label>
                        </div>
                    </div>

                    <!-- Bonus Type -->
                    <div class="row">
                        <div class="form-group bonus-fields col-md-6" style="display: none;">
                            <label for="bonous_type" class="font-weight-bold text-dark" style="font-size: 14px;">Bonus Type</label>
                            <select id="bonous_type" name="bonous_type" class="form-control">
                                <option value="" disabled selected>Select Bonus Type</option>
                                <option value="Percentage">Percentage(%)</option>
                                <option value="Fixed">Fixed</option>
                            </select>
                        </div>
    
                        <!-- Bonus Amount -->
                        <div class="form-group bonus-fields col-md-6" style="display: none;">
                            <label for="bonous_amount" class="font-weight-bold text-dark" style="font-size: 14px;">Bonus Amount ( % or Tk )</label>
                            <input type="number" id="bonous_amount" name="bonous_amount" class="form-control" placeholder="Enter Bonus Amount">
                        </div>
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
