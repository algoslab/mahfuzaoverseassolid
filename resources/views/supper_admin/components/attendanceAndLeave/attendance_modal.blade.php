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
            <form id="attendanceForm">
                @csrf
                <input type="hidden" id="attendance_id" name="attendance_id" value="">
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
                        <label for="date" class="font-weight-bold text-dark" style="font-size: 14px;">Date</label>
                        <input type="date" id="date" name="date" value="{{date("Y-m-d")}}" class="form-control" placeholder="Date">
                    </div>

                    <div class="form-group">
                        <label for="check_in" class="font-weight-bold text-dark" style="font-size: 14px;">Check In</label>
                        <input type="time" id="check_in" name="check_in" class="form-control" placeholder="Check In">
                    </div>

                    <div class="form-group">
                        <label for="check_out" class="font-weight-bold text-dark" style="font-size: 14px;">Check Out</label>
                        <input type="time" id="check_out" name="check_out" class="form-control" placeholder="Check Out">
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



