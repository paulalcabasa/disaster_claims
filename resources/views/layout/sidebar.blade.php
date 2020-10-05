<!-- Main sidebar -->
		<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

			<!-- Sidebar mobile toggler -->
			<!-- <div class="sidebar-mobile-toggler text-center">
				<a href="#" class="sidebar-mobile-main-toggle">
					<i class="icon-arrow-left8"></i>
				</a>
				Navigation
				<a href="#" class="sidebar-mobile-expand">
					<i class="icon-screen-full"></i>
					<i class="icon-screen-normal"></i>
				</a>
			</div> -->
			<!-- /sidebar mobile toggler -->


			<!-- Sidebar content -->
			<div class="sidebar-content">

				<!-- User menu -->
				<div class="sidebar-user-material">
					<div class="sidebar-user-material-body">
						<div class="card-body text-center">
							<a href="#">
								<img src="{{ asset('global_assets/images/image.png') }}" class="img-fluid rounded-circle shadow-1 mb-3" width="80" height="80" alt="">
							</a>
							<h6 class="mb-0 text-white text-shadow-dark">{{ session('user')['first_name'] . ' ' . session('user')['last_name'] }}</h6>

						</div>
													
						<div class="sidebar-user-material-footer">
							<a href="#user-nav" class="d-flex justify-content-between align-items-center text-shadow-dark dropdown-toggle" data-toggle="collapse"><span>Navigation</span></a>
						</div>
					</div>

					<div class="collapse" id="user-nav">
						<ul class="nav nav-sidebar">
							<li class="nav-item">
								<a href="{{ route('profile') }}" class="nav-link">
									<i class="icon-user-plus"></i>
									<span>My profile</span>
								</a>
							</li>
							
						
							
						</ul>
					</div>
				</div>
				<!-- /user menu -->


				<!-- Main navigation -->
				<div class="card card-sidebar-mobile">
					<ul class="nav nav-sidebar" data-nav-type="accordion">

						<!-- Main -->
					
						@if(in_array(session('user')['user_type_id'], array(42)))
						<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">CLAIMS</div> <i class="icon-menu" title="Main"></i></li>
						<li class="nav-item">
							<a href="{{ route('claim-entry') }}" class="nav-link">
								<i class="icon-pencil"></i>
								<span>Entry</span>
							</a>
						</li>
			
						<li class="nav-item nav-item-submenu nav-item-open">
							<a href="#" class="nav-link"><i class="icon-list-unordered"></i> <span>List</span></a>
							<ul class="nav nav-group-sub" data-submenu-title="Pickers" style="display: block;">
								<li class="nav-item"><a href="{{ route('claim-list') }}" class="nav-link">Claimed</a></li>
								<li class="nav-item"><a href="{{ route('unclaimed-list') }}" class="nav-link">Unclaimed</a></li>
							</ul>
						</li>
					
						@endif 
						
						@if(in_array(session('user')['user_type_id'], array(43)))
						<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">CLAIMS</div> <i class="icon-menu" title="Main"></i></li>
						<!-- <li class="nav-item">
							<a href="{{ route('admin-claims') }}" class="nav-link">
								<i class="icon-list-unordered"></i>
								<span>List</span>
							</a>
						</li> -->
						<li class="nav-item nav-item-submenu nav-item-open">
							<a href="#" class="nav-link"><i class="icon-list-unordered"></i> <span>List</span></a>
							<ul class="nav nav-group-sub" data-submenu-title="Pickers" style="display: block;">
								<li class="nav-item"><a href="{{ route('admin-claims') }}" class="nav-link">Claimed</a></li>
								<li class="nav-item"><a href="{{ route('unclaimed-list') }}" class="nav-link">Unclaimed</a></li>
							</ul>
						</li>
						<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">UNITS</div> <i class="icon-menu" title="Main"></i></li>
						<li class="nav-item">
							<a href="{{ route('affected-units-list') }}" class="nav-link">
								<i class="icon-list-unordered"></i>
								<span>Affected Units</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('affected-units-chrome') }}" class="nav-link">
								<i class="icon-list-unordered"></i>
								<span>Affected Units with Chrome</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('models') }}" class="nav-link">
								<i class="icon-list-unordered"></i>
								<span>Models</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('chrome') }}" class="nav-link">
								<i class="icon-list-unordered"></i>
								<span>Chrome Matrix</span>
							</a>
						</li>
						<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">REPORTS</div> <i class="icon-menu" title="Main"></i></li>
						<li class="nav-item">
							<a href="{{ route('reports.export_travis_rs') }}" class="nav-link">
								<i class="icon-list-unordered"></i>
								<span>TRAVIZ RS</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('reports.export_travis_pullout') }}" class="nav-link">
								<i class="icon-list-unordered"></i>
								<span>TRAVIZ PULLOUT</span>
							</a>
						</li>
						@endif 
						<!-- /main -->

					</ul>
				</div>
				<!-- /main navigation -->

			</div>
			<!-- /sidebar content -->
			
		</div>
		<!-- /main sidebar -->