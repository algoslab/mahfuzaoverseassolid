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
            <form id="airlineOfficeForm" enctype="multipart/form-data" method="POST">
                @csrf
                <input type="hidden" id="airline_office_id" name="airline_office_id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Airlines Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter Category Name" required>
                    </div>

                    <div class="form-group">
                        <label for="phone_number" class="font-weight-bold text-dark" style="font-size: 14px;">Phone Number</label>
                        <input type="number" id="phone_number" name="phone_number" class="form-control" placeholder="Enter phone number" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="font-weight-bold text-dark" style="font-size: 14px;">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email Address" required>
                    </div>

                    <div class="form-group">
                        <label>Select Airline Type</label><br>

                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="office_type" id="budget" value="budget">
                            <label class="form-check-label" for="budget">Budget Career</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="office_type" id="iata" value="iata">
                            <label class="form-check-label" for="iata">IATA</label>
                        </div>
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
