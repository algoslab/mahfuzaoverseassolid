<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('backend/assets/icons/Ionicons/css/ionicons.css') }}">

    <title>Overseas - Registation </title>
	<link rel="stylesheet" href="{{ asset('backend/assets/css/vendors_css.css') }}">
	<link rel="stylesheet" href="{{ asset('backend/assets/css/style.css')}}">
	<link rel="stylesheet" href="{{ asset('backend/assets/css/skin_color.css')}}">

</head>
	
<body class="hold-transition theme-primary bg-img" style="background-image: url(backend/images/auth-bg/bg-1.jpg)">
	
	<div class="container h-p100">
        <div class="mt-20">
            <header class="d-flex justify-content-end">
                @if (Route::has('login'))
                    <nav class="d-flex gap-2">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-outline-light btn-rounded">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-rounded">
                                Log In
                            </a>
                        @endauth
                    </nav>
                @endif
            </header>
        </div>
		<div class="row align-items-center justify-content-md-center h-p100">	
			
			<div class="col-12 p-40">
				<div class="row justify-content-center no-gutters">
					<div class="col-lg-12 col-md-12 col-12">
						<div class="bg-white rounded30 shadow-lg">
                            <div class="box box-default">
                                <div class="box-header with-border">
                                  <h3 class="text-center">Company Registration</h3>
                                  <h6 class="text-center">Register and Get Started in minutes.</h6>		
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body wizard-content">
                                    <form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data" class="validation-wizard wizard-circle">
                                        @csrf
                                        <!-- Step 1 -->
                                        <h6>Company Information</h6>
                                        <section>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="firstName5">Company Name :</label>
                                                        <input type="text" class="form-control required" id="firstName5" name="company_name" placeholder="Enter Company Name"> 
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="startDate">Start Date :</label>
                                                        <input type="date" class="form-control required" id="startDate" name="start_date"> 
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="wemailAddress2"> Email Address : <span class="danger">*</span> </label>
                                                        <input type="email" class="form-control required" id="wemailAddress2" name="email"> </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="wContactNumber">Company Contact Number :</label>
                                                        <input type="number" class="form-control required" id="wContactNumber" placeholder="Enter Conatact Number" name="contact_number"> 
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="wAlternateNumber">Alternate Contact Number :</label>
                                                        <input type="number" class="form-control" id="wAlternateNumber" name="alternate_number" placeholder="Enter Conatact Number"> 
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="district">District :</label>
                                                        <input type="text" class="form-control required" id="district" name="district" placeholder="Enter District"> 
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="city">City :</label>
                                                        <input type="text" class="form-control required" id="city" name="city" placeholder=""> 
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="countryName">Country :</label>
                                                        <input type="text" class="form-control required" id="countryName" name="country" placeholder="Enter Country Name"> 
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="zipcode">Zip Code :</label>
                                                        <input type="text" class="form-control" name="zip_code" placeholder="Enter Your Zip Code" id="phoneNumber1"> 
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <!-- Step 2 -->
                                        <h6>Owner Information</h6>
                                        <section>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="ownerName">Owner Name:</label>
                                                        <input type="text" class="form-control required" id="ownerName" name="owner_name" placeholder="Enter Owner Name">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="phoneNumber">Owner Phone Number :</label>
                                                        <input type="number" class="form-control required" id="phoneNumber" name="owner_number" placeholder="Enter Owner Number">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="emailAddress">Owner Email Address :</label>
                                                        <input type="email" class="form-control required" id="emailAddress" name="owner_email" placeholder="Enter Owner Email">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="nid_no">Owner NID NO :</label>
                                                        <input type="number" class="form-control required" id="nid_no" name="nid_no">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="nid_photo">Owner NID Upload :</label>
                                                        <input type="file" class="form-control required" id="nid_photo" name="nid_photo">
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <!-- Step 3 -->
                                        <h6>Account Setup</h6>
                                        <section>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="password">Enter Password :</label>
                                                        <input type="password" class="form-control required" id="password" name="password" placeholder="Enter Password">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="confirmPassword">Confirmed Password :</label>
                                                        <input type="password" class="form-control required" id="confirmPassword" name="confirm_password" placeholder="Confirm Password">
                                                        <span id="passwordError" style="color: red; display: none;">Passwords do not match.</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <!-- Step 4 -->
                                        <h6>Confirmation</h6>
                                        <section>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="decisions1">Comments</label>
                                                        <textarea name="comments" id="decisions1" rows="4" class="form-control"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="c-inputs-stacked">
                                                            <input type="checkbox" id="checkbox_1" name="checkbox" required> 
                                                            <label for="checkbox_1" class="d-block">Click here to indicate that you have read and agree to the terms and conditions</label>
                                                        </div>
                                                    </div>
                                                    <span id="termsError" style="color: red; display: none;">Please accept the terms and conditions.</span>
                                                </div>
                                            </div>
                                        </section>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                                <!-- /.box-body -->
                              </div>					
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- Vendor JS -->
    <script src="{{ asset('backend/assets/js/vendors.min.js')}}"></script>
	<script src="{{ asset('backend/assets/js/pages/chat-popup.js')}}"></script>
    <script src="{{ asset('backend/assets/icons/feather-icons/feather.min.js')}}"></script>	

    <script src="{{asset('backend/assets/vendor_components/jquery-steps-master/build/jquery.steps.js')}}"></script>
    <script src="{{asset('backend/assets/vendor_components/jquery-validation-1.17.0/dist/jquery.validate.min.js')}}"></script>
    <script src="{{asset('backend/assets/vendor_components/sweetalert/sweetalert.min.js')}}"></script>
	
	<!-- EduAdmin App -->
	<script src="{{asset('backend/assets/js/template.js')}}"></script>
    <script src="{{asset('backend/assets/js/pages/steps.js')}}"></script>

    <script>
        // Password matching validation
        document.getElementById('confirmPassword').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            const errorMessage = document.getElementById('passwordError');

            if (password !== confirmPassword) {
                errorMessage.style.display = 'block';
                document.getElementById('termsCheckbox').disabled = true; // Disable terms checkbox until passwords match
            } else {
                errorMessage.style.display = 'none';
                document.getElementById('termsCheckbox').disabled = false; // Enable terms checkbox if passwords match
            }
        });

        // Terms and conditions validation
        document.getElementById('registrationForm').addEventListener('submit', function(event) {
            const isTermsChecked = document.getElementById('checkbox_1').checked;
            const passwordError = document.getElementById('passwordError').style.display === 'none';

            // Show true or false based on checkbox state
            const termsStatus = isTermsChecked ? 'true' : 'false'; // If checked, show true, else false
            document.getElementById('termsStatus').textContent = termsStatus;

            // Check if passwords match and terms checkbox is selected
            if (!isTermsChecked || !passwordError) {
                event.preventDefault(); // Prevent form submission if any condition fails
                if (!isTermsChecked) {
                    document.getElementById('termsError').style.display = 'block';
                } else {
                    document.getElementById('termsError').style.display = 'none';
                }
            }
        });

    </script>
</body>
</html>


