<div class="modal fade" id="candidateCommissionSetupModal" tabindex="-1" role="dialog" aria-labelledby="candidateCommissionSetupModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="candidateCommissionSetupForm">
      @csrf
      <input type="hidden" name="candidate_id" id="commission_candidate_id">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="candidate_name_modal_title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group">
              <label>Commission Setup</label>
              <input type="text" class="form-control" name="commission" id="current_candidate_commission" value="">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-md btn-primary">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>
