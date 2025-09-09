<div class="modal fade" id="modal-center" tabindex="-1" aria-labelledby="modalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Manage Attendance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- The Form -->
            <form id="leaveForm">
                @csrf
                <input type="hidden" id="leave_id" name="leave_id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="department_id" class="font-weight-bold text-dark" style="font-size: 14px;">Choose Department </label>
                        <select name="department_id" id="departmentSelect" class="form-control" required>
                            <option value="" disabled selected>Choose Department</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="employee_id" class="font-weight-bold text-dark" style="font-size: 14px;">Choose Employee </label>
                        <select name="employee_id" id="employeeSelect" class="form-control" required>
                            <option value="" disabled selected>Choose Employee</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-700 font-size-16" for="leave_type">Leave Type</label>
                        <select name="leave_type" id="leave_type" class="form-control">
                            <option value="" disabled selected>Leave Type</option>
                            <option value="Half Day Leave">Half Day Leave</option>
                            <option value="Full Day Leave">Full Day Leave</option>
                        </select>
                    </div>

                    <div class="form-group" id="dayDiv" style="display: none">
                        <label for="leave_date" class="font-weight-bold text-dark" style="font-size: 14px;">Choose Date</label>
                        <input type="date" id="leave_date" name="leave_date" value="" class="form-control" placeholder="Expiry Date" required>
                    </div>

                    <div class="form-group">
                        <label for="no_of_days" class="font-weight-bold text-dark" style="font-size: 14px;">Number of Days</label>
                        <input type="number" step="any" value="0" id="no_of_days" name="no_of_days" class="form-control" placeholder="0" required readonly>
                    </div>
                    <div class="form-group" id="shiftDiv" style="display: none">
                        <label class="font-weight-700 font-size-16" for="shift">Shift</label>
                        <select name="shift" id="shift" class="form-control">
                            <option value="" disabled selected>Shift</option>
                            <option value="Morning">Morning</option>
                            <option value="Evening">Evening</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="opening_balance_sheet" class="font-weight-bold text-dark" style="font-size: 14px;">Attachment</label>
                        <input type="file" id="attachment" name="attachment" class="form-control form-control-lg">
                    </div>

                    <div class="form-group">
                        <label for="note" class="font-weight-bold text-dark" style="font-size: 14px;">Note</label>
                        <textarea id="note" name="note" rows="2" cols="5" class="form-control form-control-lg"></textarea>
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



