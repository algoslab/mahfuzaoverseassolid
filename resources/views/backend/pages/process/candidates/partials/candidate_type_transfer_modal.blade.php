<div class="modal fade" id="candidateTypeTransferModal" tabindex="-1" role="dialog" aria-labelledby="candidateTypeTransferModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="candidateTypeTransferForm">
      @csrf
      <input type="hidden" name="candidate_id" id="transfer_candidate_id">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="candidateTypeTransferModalLabel">Candidate Type Transfer Form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group">
              <label>From Type</label>
              <input type="text" class="form-control" id="current_candidate_type" value="" readonly>
          </div>

          <div class="form-group">
              <label for="candidate_type_id">To Type</label>
              <select name="candidate_type_id" id="candidate_type_id" class="form-control select2">
                  <option value="">--Select One--</option>
                  @foreach($candidateTypes as $id => $name)
                      <option value="{{ $id }}">{{ $name }}</option>
                  @endforeach
              </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-md btn-primary">Transfer</button>
        </div>
      </div>
    </form>
  </div>
</div> 