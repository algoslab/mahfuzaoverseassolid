<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar position-relative">	
	  	<div class="multinav">
		  <div class="multinav-scroll" style="height: 100%;">	
			  <!-- sidebar menu-->
			  <ul class="sidebar-menu" data-widget="tree">	
				<li>
				  <a href="{{route('dashboard')}}">
					<i class="fas fa-house-user"><span class="path1"></span><span class="path2"></span></i>
					<span>Dashboard</span>
					<span class="pull-right-container"></span>
				  </a>
				</li>
				<li class="treeview">
				  <a href="#">
					<i class="fas fa-user-cog"><span class="path1"></span><span class="path2"></span></i>
					<span>User & Role</span>
					<span class="pull-right-container">
					  <i class="fa fa-angle-right pull-right"></i>
					</span>
				  </a>
				  <ul class="treeview-menu">
					<li><a href=""><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Users</a></li>
					<li><a href=""><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Roles & Permissions</a></li>		
				  </ul>
				</li>
				<li class="treeview">
					<a href="#">
					  <i class="fas fa-store"><span class="path1"></span><span class="path2"></span></i>
					  <span>Companies</span>
					  <span class="pull-right-container">
						<i class="fa fa-angle-right pull-right"></i>
					  </span>
					</a>
					<ul class="treeview-menu">		
						<li><a href="{{ route('companies.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Company List</a></li>
						<li><a href=""><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Approval Company</a></li>
					</ul>
				</li>

				<li class="treeview">
					<a href="#">
					  <i class="fa-solid fa-plane-departure"><span class="path1"></span><span class="path2"></span></i>
					  <span>Services</span>
					  <span class="pull-right-container">
						<i class="fa fa-angle-right pull-right"></i>
					  </span>
					</a>
					<ul class="treeview-menu">		
						<li><a href="{{ route('supper_admin.air-ticket.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Air Ticket</a></li>
						<li><a href="{{ route('supper_admin.hazz-umrah.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Hazz & Umrah</a></li>
						<li><a href="{{ route('supper_admin.workpermits.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Work Permit Visa</a></li>
					</ul>
				</li>
				
				<li class="treeview">
					<a href="#">
					  <i class="fa-solid fa-plane-departure"><span class="path1"></span><span class="path2"></span></i>
					  <span>Advance Features</span>
					  <span class="pull-right-container">
						<i class="fa fa-angle-right pull-right"></i>
					  </span>
					</a>
					<ul class="treeview-menu">		
						<li><a href="{{ route('supper_admin.mikrotik-devices.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Add Router</a></li>
					</ul>
				</li>
				<li class="treeview">
					<a href="#">
					  <i class="fa-solid fa-location-dot"><span class="path1"></span><span class="path2"></span></i>
					  <span>Location</span>
					  <span class="pull-right-container">
						<i class="fa fa-angle-right pull-right"></i>
					  </span>
					</a>
					<ul class="treeview-menu">		
						<li><a href="{{ route('supper_admin.continents.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Continent</a></li>
						<li><a href="{{ route('supper_admin.countries.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Country</a></li>
						<li><a href="{{ route('supper_admin.divisions.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Division</a></li>
						<li><a href="{{ route('supper_admin.districts.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>District</a></li>
						<li><a href="{{ route('supper_admin.thanas.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Thana</a></li>
						<li><a href="{{ route('supper_admin.postoffices.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Post Office</a></li>
						<li><a href="{{ route('supper_admin.states.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Country Wise State</a></li>
						<li><a href="{{ route('supper_admin.currencies.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Currency</a></li>
					</ul>
				</li>
					<li class="treeview">
					<a href="#">
					  <i class="fas fa-store"><span class="path1"></span><span class="path2"></span></i>
					  <span>Enquiry</span>
					  <span class="pull-right-container">
						<i class="fa fa-angle-right pull-right"></i>
					  </span>
					</a>
					<ul class="treeview-menu">
						{{-- <li class="treeview {{ request()->routeIs('admin.phone-calls.*') ? 'active menu-open' : '' }}">
							<a href="#">
								<i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
								Phone Calls
								<span class="pull-right-container">
									<i class="fa fa-angle-right pull-right"></i>
								</span>
							</a>
							<ul class="treeview-menu" style="{{ request()->routeIs('admin.candidates.*') ? 'display: block;' : '' }}">

							</ul>
						</li> --}}
						<li class="{{ request()->routeIs('admin.phone-calls.index') ? 'active menu-open' : '' }}">
							<a href="{{ route('admin.phone-calls.index') }}">
								<i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
								Phone Calls
							</a>
						</li>
						<li class="{{ request()->routeIs('admin.visitor-books.index') ? 'active menu-open' : '' }}">
							<a href="{{ route('admin.visitor-books.index') }}">
								<i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
								Visitor Book
							</a>
						</li>
						<li class="{{ request()->routeIs('admin.interviewed-candidates.index') ? 'active menu-open' : '' }}">
							<a href="{{ route('admin.interviewed-candidates.index') }}">
								<i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
								Inv: Candidates
							</a>
						</li>
					</ul>
				</li>

				

				  <li class="treeview">
					<a href="#">
					  <i class="fa-solid fa-users"><span class="path1"></span><span class="path2"></span></i>
					  <span>Settings</span>
					  <span class="pull-right-container">
						<i class="fa fa-angle-right pull-right"></i>
					  </span>
					</a>
					<ul class="treeview-menu">		
						<li><a href=""><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>General Setting</a></li>
						<li><a href=""><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Customer List</a></li>
					</ul>
				</li>
				<li>
					<a href="#">
					  <i class="fas fa-sign-out-alt"><span class="path1"></span><span class="path2"></span></i>
					  <span>Logout</span>
					</a>
				</li>

			  </ul>
		  </div>
		</div>
    </section>
  </aside>