<div class="modal fade" id="modal-center" tabindex="-1" aria-labelledby="modalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Job Name</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- The Form -->
            <form id="jobListForm" enctype="multipart/form-data" method="POST">
                @csrf
                <input type="hidden" id="job_list_id" name="job_list_id" value="">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Select Job Category </label>
                        <select name="job_category_id" id="jobCategorySelect" class="form-control select2" required>
                            <option value="" disabled selected>Select Job Category</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Job Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter Category Name" required>
                    </div>

                    <div class="form-group">
                        <label for="job_type" class="font-weight-bold text-dark" style="font-size: 14px;">Select Job Type </label>
                        <select name="job_type" id="job_type" class="form-control select2" required>
                            <option value="" disabled selected>Select Job type</option>
                            <option value="paid">Paid</option>
                            <option value="comission">Comission</option>
                        </select>
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
