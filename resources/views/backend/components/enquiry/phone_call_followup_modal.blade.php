<div class="modal fade" id="phoneCallFollowupModal" tabindex="-1" aria-labelledby="phoneCallFollowupModalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="phoneCallFollowupModalTitle">Add Follow Up</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="phoneCallFollowupForm" method="POST">
                @csrf
                <input type="hidden" id="followup_phone_call_id" name="phone_call_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="process">Process <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="process" name="process">
                            <option value="">Select Process</option>
                            <option value="Continue">Continue</option>
                            <option value="Close">Close</option>
                            <option value="Not Started Yet">Not Started Yet</option>
                            <option value="Buissness Man">Buissness Man</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="followup_datee">Followup Date</label>
                        <input type="date" class="form-control" id="followup_datee" name="followup_datee">
                    </div>
                    <div class="form-group">
                        <label for="followup_time">Followup Time</label>
                        <input type="time" class="form-control" id="followup_time" name="followup_time">
                    </div>
                    <div class="form-group">
                        <label for="note">Note</label>
                        <textarea class="form-control" id="followup_note" name="note"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="savePhoneCallFollowupBtn">
                        <i class="fa fa-save"></i> <span id="phoneCallFollowupModalSubmitText">Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div> 