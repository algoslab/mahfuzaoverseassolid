<div class="modal fade" id="modal-center" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
        
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTitle">
                    <i class="fa fa-upload"></i> Upload Air Ticket CSV
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form action="{{ route('admin.air-ticket.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- File Input -->
                    <div class="mb-3">
                        <label for="csv_file" class="form-label"><strong>Select CSV File</strong></label>
                        <input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv" required>
                        <small class="text-muted">Only CSV files are allowed.</small>
                    </div>

                    <!-- CSV Download Button -->
                    <div class="mb-3">
                        <a href="{{ route('admin.air-ticket.download-template') }}" class="btn btn-info btn-sm">
                            <i class="fa fa-download"></i> Download Sample CSV
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-cloud-upload"></i> Upload & Import
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
