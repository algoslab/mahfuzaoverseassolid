<div class="modal fade" id="modal-center" tabindex="-1" aria-labelledby="modalTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="box-body wizard-content">
                <form id="employeeFrom" method="POST" enctype="multipart/form-data" class="validation-wizard wizard-circle">
                    @csrf
					
					<!-- Step 1 -->
					<h6>General <i class="fa fa-fw fa-angle-double-right"></i></h6>
					<section>
						<input type="hidden" id="employee_id" name="employee_id">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="first_name"> First Name : <span class="text-danger">*</span> </label>
									<input type="text" class="form-control required" id="first_name" name="first_name"> </div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="last_name"> Last Name : <span class="text-danger">*</span> </label>
									<input type="text" class="form-control required" id="last_name" name="last_name"> 
								</div>
							</div>
                            <div class="col-md-3">
								<div class="form-group">
									<label for="religion"> Religion : <span class="text-danger">*</span> </label>
                                    <select class="custom-select form-control" id="religion" name="religion" required>
                                        <option selected="selected" disabled value="">Select Religion</option>
                                        <option>Christianity</option>
                                        <option>Islam</option>
                                        <option>Hinduism</option>
                                        <option>Buddhism</option>
                                        <option>Sikhism</option>
                                        <option>Judaism</option>
                                      </select>
								</div>
							</div>
                            <div class="col-md-3">
								<div class="form-group">
									<label for="gender"> Gender : <span class="text-danger">*</span> </label>
									<select class="custom-select form-control" id="gender" name="gender" required>
										<option selected="selected" disabled value="">Select Gender</option>
										<option value="Male">Male</option>
										<option value="Female">Female</option>
										<option value="Genderqueer">Genderqueer</option>
                                        <option value="Two-Spirit">Two-Spirit</option>
                                        <option value="Others">Others</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
                            <div class="col-md-3">
								<div class="form-group">
									<label for="marital_status"> Marital Statis : <span class="text-danger">*</span> </label>
									<select class="custom-select form-control" id="marital_status" name="marital_status" required>
										<option value="">Select Status</option>
										<option value="Single">Single</option>
										<option value="Married">Married</option>
										<option value="Widowed">Widowed</option>
										<option value="Divorced">Divorced</option>
										<option value="Separated">Separated</option>
										<option value="Engaged">Engaged</option>
										<option value="In a Relationship">In a Relationship</option>
										<option value="Civil Union">Civil Union</option>
										<option value="Domestic Partnership">Domestic Partnership</option>
									</select>
								</div>
							</div>
                            <div class="col-md-3">
								<div class="form-group">
									<label for="date_of_birth">Date Of Birth (certificate) : <span class="text-danger">*</span> </label>
									<input type="date" class="form-control required" id="date_of_birth" name="date_of_birth"> </div>
							</div>
                            <div class="col-md-3">
								<div class="form-group">
									<label for="date_of_joining">Date Of Joining (certificate) : <span class="text-danger">*</span> </label>
									<input type="date" class="form-control required" id="date_of_joining" name="date_of_joining"> </div>
							</div>
                            <div class="col-md-3">
								<div class="form-group">
									<label for="blood_group">Blood Group : <span class="text-danger">*</span> </label>
									<select class="custom-select form-control" id="blood_group" name="blood_group" required>
										<option value="">Select City</option>
										<option value="A+">A+</option>
										<option value="A-">A-</option>
										<option value="B+">B+</option>
                                        <option value="B-">B−</option>
                                        <option value="AB+">AB+</option>
                                        <option value="AB-">AB-</option>
                                        <option value="O+">O+</option>
                                        <option value="O-">O-</option>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="personal_email"> Email Address : <span class="text-danger">*</span> </label>
									<input type="email" class="form-control required" id="personal_email" name="personal_email"> </div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="personal_phone">Phone Number : <span class="text-danger">*</span></label>
									<input type="tel" class="form-control" id="personal_phone" name="personal_phone" required> 
								</div>
							</div>
                            <div class="col-md-3">
								<div class="form-group">
									<label for="contact_person_number">Contact Person Number :</label>
									<input type="tel" class="form-control" id="contact_person_number" name="contact_person_number" required>
								</div>
							</div>
                            <div class="col-md-3">
								<div class="form-group">
									<label for="photo">Photo :<span class="text-danger">*</span></label>
									<input type="file" class="form-control" id="photo" name="photo">
									<img id="existing-picture" src="" alt="Current Picture" width="100" style="display:none;"> 
								</div>
							</div>
                            <div class="col-md-3">
								<div class="form-group">
									<label for="office_email">Office Email:<span class="text-danger">*</span> <span class="text-danger">*</span> </label>
									<input type="email" class="form-control required" id="office_email" name="office_email"> 
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="office_phone">Office Phone:<span class="text-danger">*</span></label>
									<input type="tel" class="form-control" id="office_phone" name="office_phone" required> 
                                </div>
							</div>
                            <div class="col-md-3">
								<div class="form-group">
									<label for="nid_number">NID/Passport :<span class="text-danger">*</span></label>
									<input type="text" class="form-control" id="nid_number" name="nid_number" required> 
                                </div>
							</div>
                            <div class="col-md-3">
								<div class="form-group">
									<label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Location(Branch) </label>
									<select name="branch_id" id="branchSelect" class="form-control" required>
										<option value="" disabled selected>Select a Branch</option>
									</select>
								</div>
							</div>
                            <div class="col-md-6">
								<div class="form-group">
									<label for="current_address">Current Address :<span class="text-danger">*</span></label>
									<textarea name="current_address" id="current_address" rows="3" class="form-control" required></textarea>
								</div>
							</div>
                            <div class="col-md-6">
								<div class="form-group">
									<label for="permanent_address">Parmanent Addres :<span class="text-danger">*</span></label>
									<textarea name="permanent_address" id="permanent_address" rows="3" class="form-control" required></textarea>
								</div>
							</div>
                            <div class="col-md-12">
								<div class="form-group">
									<label for="note">Note :</label>
									<textarea name="note" id="note" rows="3" class="form-control"></textarea>
								</div>
							</div>
						</div>
					</section>
					<!-- Step 2 -->
					<h6>Payroll <i class="fa fa-fw fa-angle-double-right"></i></h6>
					<section>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="employee_code">Employee Code :</label>
									<input type="text" class="form-control" name="employee_code" value="1000X" id="employee_code" readonly>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Role:<span class="text-danger">*</span> </label>
									<select name="role_id" id="roleSelect" class="form-control" required>
										<option value="" disabled selected>Select a Role</option>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Department:<span class="text-danger">*</span> </label>
									<select name="department_id" id="departmentSelect" class="form-control" required>
										<option value="" disabled selected>Select a Department</option>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Designation: <span class="text-danger">*</span></label>
									<select name="designation_id" id="designationSelect" class="form-control" required>
										<option value="" disabled selected>Select a Designation</option>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="basic_salary_monthly">Salary/Monthly :<span class="text-danger">*</span></label>
									<input type="number" class="form-control" id="basic_salary_monthly" name="basic_salary_monthly" required>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="basic_salary_daily">Salary/Day :<span class="text-danger">*</span></label>
									<input type="number" class="form-control required" id="basic_salary_daily" name="basic_salary_daily" readonly required>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="mobile_allowance">Mobile allowance :</label>
									<input type="number" class="form-control required" name="mobile_allowance" id="mobile_allowance">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="weekend_day">Weekend Day : <span class="text-danger">*</span> </label>
									<select class="custom-select form-control" id="weekend_day" name="weekend_day" required>
										<option value="">Select Weekend</option>
										<option value="Saturday">Saturday</option>
										<option value="Sunday">Sunday</option>
										<option value="Monday">Monday</option>
                                        <option value="Tuesday">Tuesday</option>
                                        <option value="Wednesday">Wednesday</option>
                                        <option value="Thrusday">Thrusday</option>
                                        <option value="Friday">Friday</option>
									</select>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label for="salary_pay_method"> Salary pay method : <span class="text-danger">*</span> </label>
									<select class="custom-select form-control required" id="salary_pay_method" name="salary_pay_method">
										<option value="">Select City</option>
										<option value="Cash">Cash</option>
										<option value="Bank">Bank</option>
									</select>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label for="contract_type"> Contract type :<span class="text-danger">*</span> </label>
									<select class="custom-select form-control required" id="contract_type" name="contract_type">
										<option value="">Select Contract type</option>
										<option value="Parmanent">Parmanent</option>
										<option value="Probation">Probation</option>
									</select>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label for="access_card">Access card : <span class="text-danger">*</span></label>
									<input type="text" class="form-control required" name="access_card" id="access_card">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="name" class="font-weight-bold text-dark" style="font-size: 14px;">Roster </label>
									<select name="roster_id" id="rosterSelect" class="form-control" required>
										<option value="" disabled selected>Select a Roster</option>
									</select>
								</div>
							</div>
							
						</div>
					</section>
					<!-- Step 3 -->
					<h6>Confirmation <i class="fa fa-fw fa-angle-double-right"></i></h6>
					<section>
						<div class="container mt-4">
							<h4 class="mb-3">Step 3: Confirm Employee Details</h4>
							
							<!-- General Information -->
							<div class="card mb-4">
							  <div class="card-header bg-success text-white">General Information</div>
							  <div class="card-body row">
								<div class="col-md-6"><strong>First Name:</strong> <span id="step3_first_name"></span></div>
								<div class="col-md-6"><strong>Last Name:</strong> <span id="step3_last_name"></span></div>
								<div class="col-md-6"><strong>Religion:</strong> <span id="step3_religion"></span></div>
								<div class="col-md-6"><strong>Gender:</strong> <span id="step3_gender"></span></div>
								<div class="col-md-6"><strong>Marital Status:</strong> <span id="step3_marital_status"></span></div>
								<div class="col-md-6"><strong>Date of Birth:</strong> <span id="step3_date_of_birth"></span></div>
								<div class="col-md-6"><strong>Date of Joining:</strong> <span id="step3_date_of_joining"></span></div>
								<div class="col-md-6"><strong>Blood Group:</strong><span id="step3_blood_group"></span></div>
								<div class="col-md-6"><strong>Personal Email:</strong><span id="step3_personal_email"></span></div>
								<div class="col-md-6"><strong>Personal Phone:</strong> <span id="step3_personal_phone"></span></div>
								<div class="col-md-6"><strong>Contact Person Number:</strong> <span id="step3_contact_person_number"></span></div>
								<div class="col-md-6"><strong>NID/Passport No.:</strong> <span id="step3_nid_number"></span></div>
								<div class="col-md-6"><strong>Office Email:</strong> <span id="step3_office_email"></span></div>
								<div class="col-md-6"><strong>Office Phone:</strong> <span id="step3_office_phone"></span></div>
								<div class="col-md-6"><strong>Current Address:</strong> <span id="step3_current_address"></span></div>
								<div class="col-md-6"><strong>Permanent Address:</strong> <span id="step3_permanent_address"></span></div>
								<div class="col-md-6"><strong>Note:</strong> <span id="step3_note"></span></div>
								<div class="col-md-6">
								  <strong>Photo:</strong><br>
								  <img src="" alt="Employee Photo" id="step3_photo" class="img-thumbnail mt-2" style="max-width: 150px;">
								</div>
							  </div>
							</div>
						  
							<!-- Payroll & Role Information -->
							<div class="card mb-4">
							  <div class="card-header bg-warning text-dark">Payroll & Role Information</div>
							  <div class="card-body row">
								<div class="col-md-6"><strong>Employee Code:</strong> <span id="step3_employee_code"></span></div>
								<div class="col-md-6"><strong>Role:</strong> <span id="step3_roleSelect"></span></div>
								<div class="col-md-6"><strong>Branch/Location:</strong> <span id="step3_branchSelect"></span></div>
								<div class="col-md-6"><strong>Department:</strong> <span id="step3_departmentSelect"></span></div>
								<div class="col-md-6"><strong>Designation:</strong> <span id="step3_designationSelect"></span></div>
								<div class="col-md-6"><strong>Roster:</strong> <span id="step3_rosterSelect"></span></div>
								<div class="col-md-6"><strong>Salary/Monthly:</strong> <span id="step3_basic_salary_monthly"></span></div>
								<div class="col-md-6"><strong>Salary/Day :</strong> <span id="step3_basic_salary_daily"></span></div>
								<div class="col-md-6"><strong>Mobile allowance:</strong> <span id="step3_mobile_allowance"></span></div>
								<div class="col-md-6"><strong>Weekend Day :</strong> <span id="step3_weekend_day"></span></div>
								<div class="col-md-6"><strong>Salary pay method:</strong> <span id="step3_salary_pay_method"></span></div>
								<div class="col-md-6"><strong>Contract type:</strong> <span id="step3_contract_type"></span></div>
								<div class="col-md-6"><strong>Access card :</strong> <span id="step3_access_card"></span></div>
							  </div>
							</div>
						  
					</section>
				</form>
			</div>
        </div>
    </div>
</div>
