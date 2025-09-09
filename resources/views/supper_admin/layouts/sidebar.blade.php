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

				
				 @php
                      $sponsorRoutes = [
                          'supper_admin.sponsors.*',
                          'supper_admin.visas.*',
                          'supper_admin.marketing-visas.*',
                      ];
                  @endphp
                  <li class="treeview {{ Request::routeIs(...$sponsorRoutes) ? 'active' : '' }}">
                      <a href="#">
                          <i class="mdi mdi-account-star"><span class="path1"></span><span class="path2"></span></i>
                          <span>Sponsor</span>
                          <span class="pull-right-container">
						<i class="fa fa-angle-right pull-right"></i>
					  </span>
                      </a>
                      <ul class="treeview-menu" @if (Request::routeIs(...$sponsorRoutes)) style="display: block;" @endif>

                          <li class="{{ Request::routeIs('supper_admin.sponsors.*') ? 'active' : '' }}"><a href="{{ route('supper_admin.sponsors.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Manage Sponsor</a></li>
                          <li class="{{ Request::routeIs('supper_admin.visas.*') ? 'active' : '' }}"><a href="{{ route('supper_admin.visas.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Manage Visa</a></li>
{{--                          <li class="{{ Request::routeIs('supper_admin.marketing-visas.*') ? 'active' : '' }}"><a href="{{ route('supper_admin.marketing-visas.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Marketing Visa</a></li>--}}
                      </ul>
                  </li>
                  @php
                      $payRollRoutes = [
                          'supper_admin.expense-categories.*',
                          'supper_admin.expense-items.*',
                          'supper_admin.expenses.*',
                          'supper_admin.salary-generate.*',
                          'supper_admin.performance-bonuses.*',
                          'supper_admin.inc-and-deces.*',
                          'supper_admin.advance-salaries.*',
                          'supper_admin.traveling-and-darenesses.*',
                          'supper_admin.hold-or-allowances.*',
                          'supper_admin.mobile-allowances.*',
                          'supper_admin.festival-bonuses.*',
                      ];
                  @endphp
                  <li class="treeview {{ Request::routeIs(...$payRollRoutes) ? 'active' : '' }}">
                      <a href="#">
                          <i class="fa-solid fa fa-balance-scale"><span class="path1"></span><span class="path2"></span></i>
                          <span>Payroll</span>
                          <span class="pull-right-container">
						<i class="fa fa-angle-right pull-right"></i>
					  </span>
                      </a>
                      <ul class="treeview-menu" @if (Request::routeIs(...$payRollRoutes)) style="display: block;" @endif>

                          @php
                              $expenseRoutes = [
                                  'supper_admin.expense-categories.*',
                                  'supper_admin.expense-items.*',
                                  'supper_admin.expenses.*'
                              ];
                          @endphp

                          <li class="treeview {{ Request::routeIs(...$expenseRoutes) ? 'active' : '' }}">
                              <a href="">
                                  <i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>
                                  <span>Expense</span>
                                  <span class="pull-right-container">
						<i class="fa fa-angle-right pull-right"></i>
					  </span>
                                  <ul class="treeview-menu" @if (Request::routeIs(...$expenseRoutes)) style="display: block;" @endif>
                                      <li class="{{ Request::routeIs('supper_admin.expense-categories.*') ? 'active' : '' }}"><a href="{{ route('supper_admin.expense-categories.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Expense Category</a></li>
                                      <li class="{{ Request::routeIs('supper_admin.expense-items.*') ? 'active' : '' }}"><a href="{{ route('supper_admin.expense-items.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Expense Item</a></li>
                                      <li class="{{ Request::routeIs('supper_admin.expenses.*') ? 'active' : '' }}"><a href="{{ route('supper_admin.expenses.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Add Expense</a></li>
                                  </ul>
                              </a></li>
                          <li class="{{ Request::routeIs('supper_admin.salary-generate.*') ? 'active' : '' }}"><a href="{{ route('supper_admin.salary-generate.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Salary Generate</a></li>
                          <li class="{{ Request::routeIs('supper_admin.performance-bonuses.*') ? 'active' : '' }}"><a href="{{ route('supper_admin.performance-bonuses.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Performance Bonus</a></li>
                          <li class="{{ Request::routeIs('supper_admin.inc-and-deces.*') ? 'active' : '' }}"><a href="{{ route('supper_admin.inc-and-deces.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Inc & Dec</a></li>
                          <li class="{{ Request::routeIs('supper_admin.advance-salaries.*') ? 'active' : '' }}"><a href="{{ route('supper_admin.advance-salaries.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Advance Salary</a></li>
                          <li class="{{ Request::routeIs('supper_admin.traveling-and-darenesses.*') ? 'active' : '' }}"><a href="{{ route('supper_admin.traveling-and-darenesses.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>TA - DA</a></li>
                          <li class="{{ Request::routeIs('supper_admin.hold-or-allowances.*') ? 'active' : '' }}"><a href="{{ route('supper_admin.hold-or-allowances.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Hold / Allowance</a></li>
                          <li class="{{ Request::routeIs('supper_admin.mobile-allowances.*') ? 'active' : '' }}"><a href="{{ route('supper_admin.mobile-allowances.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Mobile Allowance</a></li>
                          <li class="{{ Request::routeIs('supper_admin.festival-bonuses.*') ? 'active' : '' }}"><a href="{{ route('supper_admin.festival-bonuses.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Festival Bonus</a></li>
                      </ul>
                  </li>
				   @php
                      $attendanceAndLeaveRoutes = [
                          'supper_admin.attendances.*',
                          'supper_admin.leaves.*',
                          'supper_admin.roastings.*',
                          'supper_admin.weekends.*',
                      ];
                  @endphp
                  <li class="treeview {{ Request::routeIs(...$attendanceAndLeaveRoutes) ? 'active' : '' }}">
                      <a href="#">
                          <i class="fa fa-history"><span class="path1"></span><span class="path2"></span></i>
                          <span>Atte: & Leave</span>
                          <span class="pull-right-container">
						<i class="fa fa-angle-right pull-right"></i>
					  </span>
                      </a>
                      <ul class="treeview-menu" @if (Request::routeIs(...$attendanceAndLeaveRoutes)) style="display: block;" @endif>

                           <li class="{{ Request::routeIs('supper_admin.attendances.*') ? 'active' : '' }}"><a href="{{ route('supper_admin.attendances.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Add Attendance</a></li>
                          <li class="{{ Request::routeIs('supper_admin.leaves.*') ? 'active' : '' }}"><a href="{{ route('supper_admin.leaves.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Add Leave</a></li>
                          <li class="{{ Request::routeIs('supper_admin.roastings.*') ? 'active' : '' }}"><a href="{{ route('supper_admin.roastings.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Assign Roasting</a></li>
                          <li class="{{ Request::routeIs('supper_admin.weekends.*') ? 'active' : '' }}"><a href="{{ route('supper_admin.weekends.index') }}"><i class="icon-Commit"><span class="path1"></span><span class="path2"></span></i>Setup Weekend</a></li>
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