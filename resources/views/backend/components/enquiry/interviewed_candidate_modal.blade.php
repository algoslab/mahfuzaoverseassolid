<div class="modal fade" id="interviewedCandidateModal" tabindex="-1" aria-labelledby="interviewedCandidateModalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="interviewedCandidateModalTitle">Add Interviewed Candidate</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="interviewedCandidateForm" method="POST">
                @csrf
                <input type="hidden" id="interviewed_candidate_id" name="interviewed_candidate_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="phone">Phone <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="full_name">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="full_name" name="full_name">
                    </div>
                    <div class="form-group">
                        <label for="date_of_birth">Date Of Birth <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth">
                    </div>
                    <div class="form-group">
                        <label for="note">Note</label>
                        <textarea class="form-control" id="note" name="note"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="saveInterviewedCandidateBtn">
                        <i class="fa fa-save"></i> <span id="interviewedCandidateModalSubmitText">Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div> 