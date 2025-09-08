<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{asset('backend\assets\icons\Ionicons\css\ionicons.css')}}">

    <title>Overseas ERP - Log in </title>
	<!-- Vendors Style-->
	<link rel="stylesheet" href="{{ asset('backend/assets/css/vendors_css.css') }}">
	  
	<!-- Style-->  
	<link rel="stylesheet" href="{{ asset('backend/assets/css/style.css')}}">
	<link rel="stylesheet" href="{{ asset('backend/assets/css/skin_color.css')}}">

</head>
	
<body class="hold-transition theme-primary bg-img" style="background-image: url(backend/images/auth-bg/bg-1.jpg)">
	
	<div class="container h-p100">
		<div class="row align-items-center justify-content-md-center h-p100">	
			
			<div class="col-12">
				<div class="row justify-content-center no-gutters">
					<div class="col-lg-5 col-md-5 col-12">
						<div class="bg-white rounded30 shadow-lg">
							<div class="content-top-agile p-20 pb-0">
								<h2 class="text-primary">Overseas ERP Solution</h2>
								<p class="mb-0">Sign in to continue to Overseas ERP Solution.</p>
								@if(session('message'))
									<div class="alert alert-success">
										{{ session('message') }}
									</div>
								@endif
								@if(session('username') && session('password') && session('email'))
									<div class="alert alert-info">
										<p><strong>Usercode:</strong> {{ session('username') }}</p>
										<p><strong>Email :</strong> {{ session('email') }}</p>
										<p><strong>Password:</strong> {{ session('password') }}</p>
									</div>
								@endif						
							</div>
							<div class="p-40">
								<form action="{{ route('login') }}" method="post">
									@csrf
									<div class="form-group">
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text bg-transparent"><i class="ti-user"></i></span>
											</div>
											<input type="email" name="email" :value="old('email')" class="form-control pl-15 bg-transparent" placeholder="Username">
										</div>
									</div>
									<div class="form-group">
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text  bg-transparent"><i class="ti-lock"></i></span>
											</div>
											<input type="password" name="password" class="form-control pl-15 bg-transparent" placeholder="Password">
										</div>
									</div>
									  <div class="row">
										<div class="col-6">
										  <div class="checkbox">
											<input type="checkbox" id="basic_checkbox_1" >
											<label for="basic_checkbox_1">Remember Me</label>
										  </div>
										</div>
										<!-- /.col -->
										<div class="col-6">
										 <div class="fog-pwd text-right">
											<a href="javascript:void(0)" class="hover-warning"><i class="ion ion-locked"></i> Forgot Password?</a><br>
										  </div>
										</div>
										<!-- /.col -->
										<div class="col-12 text-center">
										  <button type="submit" class="btn btn-danger mt-10">SIGN IN</button>
										</div>
										<!-- /.col -->
									  </div>
								</form>	
								<div class="text-center">
									<p class="mt-15 mb-0">Don't have an account? <a href="{{ route('register') }}" class="text-warning ml-5">Sign Up</a></p>
								</div>	
							</div>						
						</div>
						{{-- <div class="text-center">
						  <p class="mt-20 text-white">- Sign With -</p>
						  <p class="gap-items-2 mb-20">
							  <a class="btn btn-social-icon btn-round btn-facebook" href="#"><i class="fa fa-facebook"></i></a>
							  <a class="btn btn-social-icon btn-round btn-twitter" href="#"><i class="fa fa-twitter"></i></a>
							  <a class="btn btn-social-icon btn-round btn-instagram" href="#"><i class="fa fa-instagram"></i></a>
							</p>	
						</div> --}}
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- Vendor JS -->
    <script src="{{ asset('backend/assets/js/vendors.min.js')}}"></script>
	<script src="{{ asset('backend/assets/js/pages/chat-popup.js')}}"></script>
    <script src="{{ asset('backend/assets/icons/feather-icons/feather.min.js')}}"></script>	

</body>

<!-- Mirrored from eduadmin-template.multipurposethemes.com/bs4/main/auth_login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 04 Jun 2022 07:41:31 GMT -->
</html>
