<div class="modal fade" id="modal-center" tabindex="-1" aria-labelledby="modalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Process Step</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- The Form -->
            <form id="processStepsForm" enctype="multipart/form-data" method="POST">
                @csrf
                <input type="hidden" id="process_step_id" name="process_step_id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Process Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter Name" required>
                    </div>


                    <div class="form-group">
                        <label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Select Country</label>
                        <select name="country_id[]" id="countriesSelect" class="form-control select2" multiple="multiple" data-placeholder="Select a Country"
                                style="width: 100%;">
                                <option value="" disabled>Select a Country</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Select Gender</label>
                        <select name="gender[]" id="gender" class="form-control select2" multiple="multiple" data-placeholder="Select a Gender"
                                style="width: 100%;">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Genderqueer">Genderqueer</option>
                            <option value="Two-Spirit">Two-Spirit</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Select Process Category</label>
                        <select name="process_category_id[]" id="processCategorySelect" class="form-control select2" multiple="multiple" data-placeholder="Select a process Category"
                                style="width: 100%;">
                                <option value="" disabled>Select a Country</option>
                        </select>
                    </div>

                    <input type="hidden" name="is_document" value="0">
                    <div class="form-group form-check" style="padding-left: 0px !important">
                        <input type="checkbox" id="is_document" name="is_document" class="form-check-input" value="1" >
                        <label class="form-check-label" for="is_document">Need Document</label>
                    </div>

                    <input type="hidden" name="is_scheduled" value="0">
                    <div class="form-group form-check" style="padding-left: 0px !important">
                        <input type="checkbox" id="is_scheduled" name="is_scheduled" class="form-check-input" value="1">
                        <label class="form-check-label" for="is_scheduled">Need Scheduled</label>
                    </div>

                    <input type="hidden" name="is_youtube_link" value="0">
                    <div class="form-group form-check" style="padding-left: 0px !important">
                        <input type="checkbox" id="is_youtube_link" name="is_youtube_link" class="form-check-input" value="1">
                        <label class="form-check-label" for="is_youtube_link">Need Youtube Link</label>
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
