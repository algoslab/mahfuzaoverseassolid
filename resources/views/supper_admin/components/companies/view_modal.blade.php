<div class="modal modal-left fade" id="modal-left" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document" style="width: 800px; !important">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Company Information</h5>
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-4 bg-light">
            <div class="card border-0">
              <div class="card-header bg-dark text-white text-center" style="background-image: url('backend/images/gallery/full/10.jpg'); background-size: cover;">
                <h3 id="companyName" class="mb-1">Company Name</h3>
                <small id="companyCode">Company Code</small>
              </div>
    
              <div class="card-body">
                <div class="text-center mb-4">
                  <img id="logo" src="" alt="Company Logo" class="rounded-circle shadow" style="width: 100px; height: 100px;">
                </div>
    
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <strong>Email:</strong> <span id="email" class="text-muted d-block"></span>
                    <strong>Phone:</strong> <span id="contactNumber" class="text-muted d-block"></span>
                    <strong>Alternate Phone:</strong> <span id="alternateNumber" class="text-muted d-block"></span>
                    <strong>Status:</strong> <span id="status" class="text-muted d-block"></span>
                  </div>
    
                  <div class="col-md-6 mb-3">
                    <strong>Owner Name:</strong> <span id="ownerName" class="text-muted d-block"></span>
                    <strong>Owner Phone:</strong> <span id="ownerNumber" class="text-muted d-block"></span>
                    <strong>Owner Email:</strong> <span id="ownerEmail" class="text-muted d-block"></span>
                    <strong>Status:</strong> <span id="statusBadge" class="badge text-white"></span>
                  </div>
    
                  <div class="col-md-12 mb-3">
                    <strong>Address:</strong>
                    <p id="address" class="text-muted mb-1"></p>
    
                    <strong>NID No:</strong>
                    <p id="nidNo" class="text-muted mb-1"></p>
    
                    <strong>Comments:</strong>
                    <p id="comments" class="text-muted"></p>
                  </div>
    
                  <div class="row">

                    <!-- NID Photo -->
                    <div class="col-md-6 col-lg-3 mb-4">
                      <div class="card shadow-sm border-0 text-center h-100">
                        <div class="card-header bg-primary text-white py-2">
                          NID Photo
                        </div>
                        <div class="card-body">
                          <img id="nidPhoto" src="" alt="NID Photo" class="img-fluid rounded mb-2" style="max-height: 150px;">
                        </div>
                      </div>
                    </div>
                  
                    <!-- Owner Image -->
                    <div class="col-md-6 col-lg-3 mb-4">
                      <div class="card shadow-sm border-0 text-center h-100">
                        <div class="card-header bg-info text-white py-2">
                          Owner Image
                        </div>
                        <div class="card-body">
                          <img id="ownerPhoto" src="" alt="Owner Image" class="img-fluid rounded mb-2" style="max-height: 150px;">
                        </div>
                      </div>
                    </div>
                  
                    <!-- Company Logo -->
                    <div class="col-md-6 col-lg-3 mb-4">
                      <div class="card shadow-sm border-0 text-center h-100">
                        <div class="card-header bg-success text-white py-2">
                          Company Logo
                        </div>
                        <div class="card-body">
                          <img id="logo" src="" alt="Company Logo" class="img-fluid rounded-circle mb-2" style="max-height: 150px;">
                        </div>
                      </div>
                    </div>
                  
                    <!-- Trade License -->
                    <div class="col-md-6 col-lg-3 mb-4">
                      <div class="card shadow-sm border-0 text-center h-100">
                        <div class="card-header bg-warning text-dark py-2">
                          Trade License
                        </div>
                        <div class="card-body">
                          <img id="tradeLicense" src="" alt="Trade License" class="img-fluid rounded mb-2" style="max-height: 150px;">
                        </div>
                      </div>
                    </div>
                  
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
        <div class="modal-footer modal-footer-uniform">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="modalChangeStatusBtn" class="btn btn-primary">Change Status</button>
          <button type="button" class="btn btn-primary float-right">Save changes</button>
        </div>
      </div>
    </div>
  </div>
