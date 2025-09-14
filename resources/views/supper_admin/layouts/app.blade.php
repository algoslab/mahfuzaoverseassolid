<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>@yield('title', 'Career Guideline')</title>
	<link rel="stylesheet" href="{{ asset('backend/assets/css/vendors_css.css') }}">
	<link rel="stylesheet" href="{{ asset('backend/assets/vendor_components/datatable/datatables.min.css') }}">
	<link rel="stylesheet" href="{{ asset('backend/assets/css/style.css')}}">
	<link rel="stylesheet" href="{{ asset('backend/assets/css/skin_color.css')}}">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
	@yield('style')

	<script>
        window.routes = {
            countryActive: "{{ route('admin.country.active') }}",
			divisionActive: "{{ route('supper_admin.division.active') }}",
			districtActive: "{{ route('supper_admin.district.active') }}",
			thanaActive: "{{ route('supper_admin.thana.active') }}",
			employeeActive: "{{ route('admin.employee.active') }}",
			companyActive: "{{ route('supper_admin.company.active') }}",
			branchActive: "{{ route('admin.branch.active') }}",
        };
    </script>
  </head>

<body class="hold-transition light-skin sidebar-mini theme-primary fixed">
	
<div class="wrapper">
  <div id="loader"></div>
  <header class="main-header">
	<div class="d-flex align-items-center logo-box justify-content-start">
		<a href="#" class="waves-effect waves-light nav-link d-none d-md-inline-block mx-10 push-btn bg-transparent" data-toggle="push-menu" role="button">
			<span class="icon-Align-left"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
		</a>	
		<a href="{{route('dashboard')}}" class="logo">
		  <div class="logo-lg">
			  <span class="light-logo"><img src="{{ asset('backend\images\overseas.jpeg')}}" alt="logo"></span>
			  <span class="dark-logo"><img src="{{ asset('backend\images\overseas.jpeg')}}" alt="logo"></span>
		  </div>
		</a>	
	</div>  

        @include('supper_admin.layouts.navbar')
  </header>
  
  @include('supper_admin.layouts.sidebar')


  <div class="content-wrapper" style="background-color: #e3e3e3">
	  <div class="container-full">
        <main>
            @yield('content')
        </main>
	  </div>
  </div>

  @include('supper_admin.layouts.footer');


  <div class="control-sidebar-bg"></div>
  
</div>

	<!-- Vendor JS -->
	<script src="{{ asset('backend/assets/js/vendors.min.js')}}"></script>
	<script src="{{ asset('backend/assets/js/pages/chat-popup.js')}}"></script>
    <script src="{{ asset('backend/assets/icons/feather-icons/feather.min.js')}}"></script>	
	<script src="{{asset('backend/assets/vendor_components/select2/dist/js/select2.full.js')}}"></script>

	{{-- <script src="{{ asset('backend/assets/vendor_components/apexcharts-bundle/dist/apexcharts.js')}}"></script> --}}
	<!-- Include ApexCharts Library -->
	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

	<script src="{{ asset('backend/assets/vendor_components/moment/min/moment.min.js')}}"></script>
	<script src="{{ asset('backend/assets/vendor_components/fullcalendar/fullcalendar.js')}}"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>

	<!-- EduAdmin App -->
	<script src="{{ asset('backend/assets/js/template.js')}}"></script>
	<script src="{{ asset('backend/assets/js/pages/dashboard3.js')}}"></script>
	<script src="{{ asset('backend/assets/js/pages/calendar.js')}}"></script>
	<script src="{{ asset('backend/assets/vendor_components/dropzone/dropzone.js')}}"></script>
	<script src="{{ asset('backend/assets/vendor_components/datatable/datatables.min.js')}}"></script>

    {{-- <script src="{{ asset('backend/assets/vendor_components/ckeditor/ckeditor.js')}}"></script> --}}
	<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    <script src="{{ asset('backend/assets/vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js')}}"></script>
    <script src="{{ asset('backend/assets/js/pages/editor.js')}}"></script>

	<script src="{{ asset('backend/assets/vendor_components/gallery/js/animated-masonry-gallery.js')}}"></script>
	<script src="{{ asset('backend/assets/vendor_components/gallery/js/jquery.isotope.min.js')}}"></script>
	<script src="{{ asset('backend/assets/vendor_components/lightbox-master/dist/ekko-lightbox.js')}}"></script>	    
	<script src="{{ asset('backend/assets/js/pages/gallery.js')}}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<script src="{{ asset('js/global.js') }}"></script>

	
	@yield('script')
	<script>
		$(document).ready(function() {
			$('#customDataTable').DataTable({
				paging: true,
				searching: true,
				ordering: true
			});

			$('#summernote').summernote({
				height: 200,                 
				minHeight: null,             
				maxHeight: null,             
				focus: true                 
			});
		});

		$(document).ready(function() {
			$('#leadDataTable').DataTable({
				paging: true,
				searching: true,
				ordering: true,
				dom: 'Bfrtip', // Add the Buttons
				buttons: [
					'copy',       // Copy to clipboard
					'csv',        // Export as CSV
					'excel',      // Export as Excel
					'pdf',        // Export as PDF
					'print',      // Print the table
				],
			});

			$('.select2').each(function() {
				const modalParent = $(this).closest('.modal'); // Finds the closest modal container
				$(this).select2({
					dropdownParent: modalParent,
					width: '100%'
				});
			});

		});
	  </script>


	
</body>

</html>
