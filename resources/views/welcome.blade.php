<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Overseas ERP Solution">
  <meta name="author" content="Your Company">
  <link rel="icon" href="{{ asset('backend/assets/icons/Ionicons/css/ionicons.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


  <title>Overseas ERP Solutions</title>
  <!-- Vendors Style -->
  <link rel="stylesheet" href="{{ asset('backend/assets/css/vendors_css.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/assets/css/skin_color.css') }}">


  <style>
    .search-btn-container {
      text-align: center;
      margin-top: 20px;
    }
    .nav-tabs {
      display: flex;
      justify-content: center;
      width: 100%;
    }
    .search-input {
      margin-top: 10px;
      width: 100%;
      padding: 8px;
      font-size: 16px;
    }
    .table-wrapper {
      max-height: 600px; 
      overflow-y: auto;
    }
/* 
    #customDataTable_wrapper .dataTables_scrollHead {
      position: sticky;
      top: 0;
      z-index: 10;
      background-color: white;
    } */
  </style>
</head>

<body class="hold-transition theme-primary bg-img" style="background-image: url('{{ asset('backend/images/auth-bg/bg-2.jpg') }}')">
  <div class="container h-p100">
    <div class="mt-20">
      <header class="d-flex justify-content-end">
        @if (Route::has('login'))
          <nav class="d-flex gap-2">
            @auth
              <a href="{{ url('/dashboard') }}" class="btn btn-outline-light btn-rounded">Dashboard</a>
            @else
              <a href="{{ route('login') }}" class="btn btn-outline-light btn-rounded">Log in</a>
              @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-warning btn-rounded">Register</a>
              @endif
            @endauth
          </nav>
        @endif
      </header>
    </div>


    <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg rounded-lg">
          <div class="modal-header bg-primary text-white text-center">
            <h5 class="modal-title text-center ">Book Your Ticket</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          
          <div class="modal-body text-center">
            <div class="p-3">
              <div class="d-flex justify-content-between align-items-center">
                <p class="mb-2">
                  <span id="modalFrom" class="font-weight-bold text-dark"></span>
                </p>
                --<i class="fas fa-plane-departure text-info"></i>-----------------------<strong>To</strong>-----------------------<i class="fas fa-plane-arrival text-success"></i>--
                <p class="mb-2">
                  <span id="modalTo" class="font-weight-bold text-dark"></span>
                </p>
              </div>
              
              <p class="mb-2"><strong><i class="far fa-calendar-alt text-warning"></i> Flight Date:</strong> 
                <span id="modalDate" class="font-weight-bold text-dark"></span>
              </p>
              <p class="mb-2"><strong><i class="fa-solid fa-bangladeshi-taka-sign"></i> Fare:</strong> 
                <span class="font-weight-bold text-dark">৳</span> 
                <span id="modalFare" class="font-weight-bold text-dark"></span> 
              </p>
              <p class="mb-0 bg-warning p-2 rounded">
                <strong><i class="fas fa-phone-alt text-dark"></i> Phone:</strong> 
                <span id="modalPhone" class="font-weight-bold text-dark">01329681965</span>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="workViewModal" tabindex="-1" role="dialog" aria-labelledby="workViewModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg rounded-lg">
          <div class="modal-header bg-primary text-white text-center">
            <h5 class="modal-title text-center">Work Permit Details</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          
          <div class="modal-body text-center">
            <div class="p-3">
              <!-- Image Preview -->
              <div class="mb-3">
                <img id="modalPosterImage" src="" alt="Poster Image" class="img-fluid" style="max-width: 100%; height: auto;">

              </div>
    
              <p class="mb-2"><strong><i class="far fa-calendar-alt text-warning"></i> Circular Expire Date:</strong> 
                <span id="modalexpireDate" class="font-weight-bold text-dark"></span>
              </p>
              <p class="mb-2"><strong><i class="fa-solid fa-bangladeshi-taka-sign"></i> Salary:</strong> 
                <span class="font-weight-bold text-dark">৳</span> 
                <span id="modalSalary" class="font-weight-bold text-dark"></span> 
              </p>
              <p class="mb-0 bg-warning p-2 rounded">
                <strong><i class="fas fa-phone-alt text-dark"></i> Phone:</strong> 
                <span id="modalPhone" class="font-weight-bold text-dark">01329681965</span>
              </p>
            </div>
          </div>
          
        </div>
      </div>
    </div>
    
    
    
    


    <div class="row align-items-center justify-content-md-center h-p80">
      <div class="col-12">
        <div class="row justify-content-center no-gutters">
          <div class="col-lg-10 col-md-10 col-12">
            <div class="bg-white rounded30 shadow-lg">
              <div class="content-top-agile p-20 pb-0 text-center">
                <h3 class="mb-0 text-primary">OVERSEAS ERP SOLUTION</h3>
              </div>
              <div class="p-40">
                <!-- Main Tabs -->
                <ul class="nav nav-tabs mb-3" id="visaTabs">
                  <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#air-ticket">Air Ticket</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#hazz-umrah">Hazz & Umrah</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#work-visa">Work Permit Visa</a>
                  </li>
                </ul>
    
                <!-- Tab Content -->
                <div class="tab-content">
                  
                  <!-- Air Ticket Tab -->
                  <div class="tab-pane fade show active" id="air-ticket">
                    <ul class="nav nav-tabs mb-3" id="visaTabs">
                      <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#non-refundable">Non-Refundable (Group Ticket)</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#refundable">System Ticket</a>
                      </li>
                    </ul>
                  
                    <div class="row">
                      <div class="col-6">
                        <label for="fromLocation">From:</label>
                        <select id="fromLocation" class="form-control">
                          <option value="">Select Origin</option>
                        </select>
                      </div>
                      <div class="col-6">
                        <label for="toLocation">To:</label>
                        <select id="toLocation" class="form-control" disabled>
                          <option value="">Select Destination</option>
                        </select>
                      </div>
                    </div>
                  
                    <div class="search-btn-container">
                      <button class="btn btn-primary">Search</button>
                    </div>
                  
                    <!-- Tab Content for Tickets -->
                    <div class="tab-content mt-4">
                      <!-- Non-Refundable Tab -->
                      <div class="tab-pane fade show active table-wrapper" id="non-refundable">
                        <table id="customDataTable" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>From</th>
                              <th>To</th>
                              <th>Flight Date</th>
                              <th>Transit Time</th>
                              <th>Luggage</th>
                              <th>Food</th>
                              <th>B2B Fare</th>
                              <th>B2C Fare</th>
                              <th>Group</th>
                              <th>Airport</th>
                              <th>Airlines</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody id="ticketTable">
                            <!-- Data will be injected here -->
                          </tbody>
                        </table>
                      </div>

                      <div class="tab-pane fade" id="refundable">
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th>From</th>
                              <th>To</th>
                              <th>Flight Date</th>
                              <th>Transit Time</th>
                              <th>Luggage</th>
                              <th>Food</th>
                              <th>B2B Fare</th>
                              <th>B2C Fare</th>
                              <th>Group</th>
                              <th>Airport Name</th>
                              <th>Airlines</th>
                            </tr>
                          </thead>
                          <tbody id="refundableTicketTable">
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
    
                  <!-- Hazz & Umrah Tab -->
                  <div class="tab-pane fade" id="hazz-umrah">
                    <table class="table table-bordered mt-4">
                      <thead>
                        <tr>
                          <th>Travel Date</th>
                          <th>Service Type</th>
                          <th>Package Type</th>
                          <th>Hotel Category</th>
                          <th>Mokka To Modina</th>
                          <th>Food</th>
                          <th>B2C Fare</th>
                          <th>B2B Fare</th>
                          <th>Airlines</th>
                        </tr>
                      </thead>
                      <tbody id="hazzTable"></tbody>
                    </table>
                  </div>
    
                  <!-- Work Permit Visa Tab -->
                  <div class="tab-pane fade" id="work-visa">
                    <table class="table table-bordered mt-4">
                      <thead>
                        <tr>
                          <th>Country Zone</th>
                          <th>Country</th>
                          <th>Job Position/Category</th>
                          <th>Salary</th>
                          <th>Circuler Expire Date</th>
                          <th>Ref:Code</th>
                          <th>View</th>
                        </tr>
                      </thead>
                      <tbody id="workTable"></tbody>
                    </table>
                  </div>
    
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
  </div>


  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="{{ asset('backend/assets/js/vendors.min.js')}}"></script>
  <script src="{{ asset('backend/assets/js/pages/chat-popup.js')}}"></script>
  <script src="{{ asset('backend/assets/icons/feather-icons/feather.min.js')}}"></script>
  <script src="{{ asset('backend/assets/vendor_components/datatable/datatables.min.js')}}"></script>

  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

  <script>
    let customDataTableInstance = null; 

    function initializeCustomDataTable() {
        if ($.fn.DataTable.isDataTable('#customDataTable')) {
            $('#customDataTable').DataTable().clear().destroy();
            $('#customDataTable').empty(); 
        }

        customDataTableInstance = $('#customDataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('api.airticket.active') }}',
                type: 'GET',
                error: function(xhr, error, thrown) {
                    console.error('API Error:', error);
                    alert('Error fetching data!');
                }
            },
            columns: [
                { data: 'destination_from' },
                { data: 'destination_to' },
                { data: 'flight_date' },
                { data: 'transit_time' },
                { data: 'luggage' },
                { data: 'food' },
                { data: 'b2b_fare' },
                { data: 'b2c_fare' },
                { data: 'group' },
                { data: 'full_airport_name' },
                { data: 'airlines' },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                            <button class="btn btn-primary book-now-btn" 
                                data-from="${row.destination_from}" 
                                data-to="${row.destination_to}" 
                                data-date="${row.flight_date}" 
                                data-fare="${row.b2c_fare}">
                                Book Now
                            </button>
                        `;
                    }
                }
            ],
            pageLength: 5,
            responsive: true,
            order: [[2, 'asc']],
            scrollY: '400px',
            scrollCollapse: true,
            scrollX: true,
            fixedHeader: {
                header: true
            },
            drawCallback: function(settings) {
                $('.book-now-btn').off('click').on('click', function() {
                    const from = $(this).data('from');
                    const to = $(this).data('to');
                    const date = $(this).data('date');
                    const fare = $(this).data('fare');

                    $('#modalFrom').text(from);
                    $('#modalTo').text(to);
                    $('#modalDate').text(date);
                    $('#modalFare').text(fare);

                    const myModal = new bootstrap.Modal(document.getElementById("bookingModal"));
                    myModal.show();
                });
            }
        });
    }

    $(document).ready(function() {
        initializeCustomDataTable();
    });



    document.getElementById('fromLocation').addEventListener('change', function() {
      var fromLocation = this.value;
      var toLocation = document.getElementById('toLocation');
      
      // If a value is selected in 'fromLocation', enable 'toLocation', otherwise disable it
      if (fromLocation) {
        toLocation.disabled = false;
      } else {
        toLocation.disabled = true;
      }
    });

    $(document).ready(function() {
      $('#visaTabs a').on('click', function (e) {
        e.preventDefault();
        $(this).tab('show');
      });
    });
    document.getElementById('visaTabs').addEventListener('show.bs.tab', function (event) {
        const targetTab = event.target; 
        if (targetTab.getAttribute('href') === '#refundable') {
            document.getElementById('ticketTable').innerHTML = '';
        }
    });

    document.addEventListener("DOMContentLoaded", () => {
      fetchLocationOptions();
      fetchHazzData();
      fetcworkPermitData();
    });


    function fetchHazzData() {
      axios.get("{{ route('api.hazz.active') }}")
        .then(response => {
          console.log("API Hazz Response:", response.data);
          if (Array.isArray(response.data)) {
            const hazzTable = document.getElementById("hazzTable");
            hazzTable.innerHTML = "";
            response.data.forEach(hazz => {
              const from = hazz.destination_from || "N/A";
              const to = hazz.destination_to || "N/A";
              const row = `
                <tr class="hazz-row" data-from="${from}" data-to="${to}">
                  <td>${hazz.flight_date || "N/A"}</td>
                  <td>${hazz.services || "N/A"}</td>
                  <td>${hazz.packages || "N/A"}</td>
                  <td>${hazz.hotel_category || "N/A"}</td>
                  <td>${hazz.mokka_modina_transport || "N/A"}</td>
                  <td>${hazz.meal || "N/A"}</td>
                  <td>${hazz.amount_b2c || "N/A"}</td>
                  <td>${hazz.amount_b2B || "N/A"}</td>
                  <td>
                    <button class="btn btn-primary book-now-btn" 
                      data-from="${from}" 
                      data-to="${to}" 
                      data-date="${hazz.flight_date}" 
                      data-fare="${hazz.amount_b2c}">
                      Book Now
                    </button>
                  </td>
                </tr>
              `;
              hazzTable.innerHTML += row;
            });

            // Attach event listeners to all "Book Now" buttons
            document.querySelectorAll(".book-now-btn").forEach(button => {
              button.addEventListener("click", function() {
                const from = this.getAttribute("data-from");
                const to = this.getAttribute("data-to");
                const date = this.getAttribute("data-date");
                const fare = this.getAttribute("data-fare");

                // Fill modal with ticket details
                document.getElementById("modalFrom").textContent = from;
                document.getElementById("modalTo").textContent = to;
                document.getElementById("modalDate").textContent = date;
                document.getElementById("modalFare").textContent = fare;

                // Show modal
                const myModal = new bootstrap.Modal(document.getElementById("bookingModal"));
                myModal.show();
              });
            });

          } else {
            console.error('Expected an array, but got:', response.data);
            document.getElementById("ticketTable").innerHTML = "<tr><td colspan='12' class='text-center'>No tickets available</td></tr>";
          }
        })
        .catch(error => {
          console.error("API Error:", error);
          document.getElementById("ticketTable").innerHTML = "<tr><td colspan='12' class='text-center'>Error fetching data</td></tr>";
        });
    }

    function fetcworkPermitData() {
      axios.get("{{ route('api.workpermit.active') }}")
        .then(response => {
          console.log("API workpermit Response:", response.data);
          if (Array.isArray(response.data)) {
            const workTable = document.getElementById("workTable");
            workTable.innerHTML = "";  // Clear previous table content

            response.data.forEach(work => {
              const imageUrl = work.image ? "{{ asset('storage') }}/" + work.image : ""; 
              const row = `
                <tr class="work-row">
                  <td>${work.continent.name || "N/A"}</td>
                  <td>${work.country.name || "N/A"}</td>
                  <td>${work.name || "N/A"}</td>
                  <td>${work.salary || "N/A"}</td>
                  <td>${work.expire_date || "N/A"}</td>
                  <td>${work.code || "N/A"}</td>
                  <td>
                    <button class="btn btn-primary view-btn" 
                        data-date="${work.expire_date || "N/A"}" 
                        data-salary="${work.salary || "N/A"}" 
                        data-image="${imageUrl || ""}">
                      View
                    </button>
                  </td>
                </tr>
              `;
              workTable.innerHTML += row;
            });

            // Attach event listeners to all "View" buttons
            document.querySelectorAll(".view-btn").forEach(button => {
              button.addEventListener("click", function() {
                const date = this.getAttribute("data-date");
                const salary = this.getAttribute("data-salary");
                const imageUrl = this.getAttribute("data-image");

                // Fill modal with work details
                document.getElementById("modalexpireDate").textContent = date;
                document.getElementById("modalSalary").textContent = salary;
                document.getElementById("modalPosterImage").src = imageUrl || ""; // Display image

                // Show modal
                const myModal = new bootstrap.Modal(document.getElementById("workViewModal"));
                myModal.show();
              });
            });

          } else {
            console.error('Expected an array, but got:', response.data);
            document.getElementById("workTable").innerHTML = "<tr><td colspan='12' class='text-center'>No work available</td></tr>";
          }
        })
        .catch(error => {
          console.error("API Error:", error);
          document.getElementById("workTable").innerHTML = "<tr><td colspan='12' class='text-center'>Error fetching data</td></tr>";
        });
    }

    function fetchLocationOptions() {
      axios.get("{{ route('api.ticket.getDestinations') }}")
        .then(response => {
          console.log("Location API Response:", response.data);
          
          if (response.data && response.data.from_locations && response.data.to_locations) {
            let fromOptions = `<option value="">Select Origin</option>`;
            let toOptions = `<option value="">Select Destination</option>`;

            // Populate 'From' Locations
            response.data.from_locations.forEach(location => {
              fromOptions += `<option value="${location}">${location}</option>`;
            });

            // Populate 'To' Locations with Full Airport Name
            response.data.to_locations.forEach(location => {
              toOptions += `<option value="${location.code}">${location.full_name}</option>`;
            });

            // Update all dropdowns with id 'fromLocation' and 'toLocation'
            document.querySelectorAll('#fromLocation').forEach(el => { el.innerHTML = fromOptions; });
            document.querySelectorAll('#toLocation').forEach(el => { el.innerHTML = toOptions; });
          } else {
            console.warn("No valid locations found or data is not in expected format!");
          }
        })
        .catch(error => {
          console.error("API Error:", error);
        });
    }
  </script>

</body>
</html>
