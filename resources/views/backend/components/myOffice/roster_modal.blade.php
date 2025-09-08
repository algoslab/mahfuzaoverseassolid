<div class="modal fade" id="modal-center" tabindex="-1" aria-labelledby="modalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Roster</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- The Form -->
            <form id="rosterFrom" enctype="multipart/form-data" method="POST">
                @csrf
                <input type="hidden" id="roster_id" name="roster_id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Roster Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter Roster Name" required>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="code" class="font-weight-bold text-dark" style="font-size: 14px;">Roster Code</label>
                            <input type="text" id="code" name="code" class="form-control" placeholder="Enter Roster Code">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="duty_hours" class="font-weight-bold text-dark" style="font-size: 14px;">Roster Hours</label>
                            <input type="number" id="duty_hours" name="duty_hours" class="form-control" value="8" placeholder="Enter Roster Code">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="start_time" class="font-weight-bold text-dark" style="font-size: 14px;">Start Time</label>
                            <input type="time" id="start_time" name="start_time" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="end_time" class="font-weight-bold text-dark" style="font-size: 14px;">End Time</label>
                            <input type="time" id="end_time" name="end_time" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="form-group form-check" style="padding-left: 0px !important">
                        <input type="checkbox" id="meal_break" name="meal_break" class="form-check-input" value="1" >
                        <label class="form-check-label" for="meal_break">Include Meal Breck</label>
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


