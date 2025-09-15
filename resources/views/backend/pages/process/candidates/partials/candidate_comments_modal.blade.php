<div class="modal fade" id="candidateCommentsModal" tabindex="-1" role="dialog" aria-labelledby="candidateCommentsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="candidateCommentsForm">
        @csrf
        <input type="hidden" name="candidate_id" id="comments_candidate_id">
        <div class="modal-header">
          <h5 class="modal-title" id="candidateCommentsModalLabel">Candidate Comments</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
            <div class="form-group">
              <label for="new_comment" class="col-form-label">Add Comment</label>
              <textarea class="form-control" name="comments" id="new_comment" rows="5"></textarea>
            </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-md btn-primary">Add Comment</button>
        </div>
      </form> 
    </div>
  </div>
</div>