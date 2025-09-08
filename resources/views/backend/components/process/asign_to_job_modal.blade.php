<div class="modal fade" id="modal-center" tabindex="-1" aria-labelledby="modalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Candidate Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- The Form -->
            <form id="asignJobOfficeForm" enctype="multipart/form-data" method="POST">
                @csrf
                <input type="hidden" id="asign_job_office_id" name="asign_job_office_id" value="">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Choese Process Office </label>
                        <select name="proces_office_id" id="processOfficeSelect" class="form-control select2" required>
                            <option value="" disabled selected>Select Process Office</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Select Process Category </label>
                        <select name="process_category_id" id="processCategorySelect" class="form-control select2" required>
                            <option value="" disabled selected>Select Process Category</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Select Job Category </label>
                        <select name="job_category_id" id="jobCategorySelect" class="form-control select2" required>
                            <option value="" disabled selected>Select Job Category</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Select Job Name </label>
                        <select name="job_list_id" id="jobListSelect" class="form-control select2" required>
                            <option value="" disabled selected>Select Job Name</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="processing_cost" class="font-weight-bold text-dark" style="font-size: 14px;">Processing Cost</label>
                        <input type="number" id="processing_cost" name="processing_cost" class="form-control" placeholder="Enter Processing Name" required>
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
