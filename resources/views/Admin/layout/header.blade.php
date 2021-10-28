<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand">
				<a href="/index">Boldrum</a>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
				</div>
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
					
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							    <span>{{ Auth()->user()->name }}</span><i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
							<li><a href="/profile"><i class="lnr lnr-user"></i> <span>My Profile</span></a></li>
							<li><a href="/change-pass"><i class="lnr lnr-user"></i> <span>Change Password</span></a></li>
							<li><a href="{{ url('logout') }}"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
				
						 	</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li><a href="{{ url('index') }}" class="{{ (request()->segment(1) == 'index') ? 'active' : '' }}"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>						
						<li><a href="{{ route('users.index') }}" class="{{ (request()->segment(1) == 'users') ? 'active' : '' }}"><i class="lnr lnr-chart-bars"></i> <span>User</span></a></li>
						<li><a href="{{ route('order.index') }}" class="{{ (request()->segment(1) == 'order') ? 'active' : '' }}"><i class="lnr lnr-chart-bars"></i> <span>Order</span></a></li>
						@if(Auth()->user()->type == 2)
						<li><a href="{{ url('clubs') }}" class="{{ (request()->segment(1) == 'clubs') ? 'active' : '' }}"><i class="lnr lnr-code"></i> <span>Clubs</span></a></li>
						<li><a href="{{ url('ballrooms') }}" class="{{ (request()->segment(1) == 'ballrooms') ? 'active' : '' }}"><i class="lnr lnr-dice"></i> <span>Ballrooms</span></a></li> 
						<li><a href="{{ url('roles') }}" class=""><i class="lnr lnr-cog"></i> <span>Roles</span></a></li>
						<li>
							<a href="#subPages" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>Materials</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="subPages" class="collapse">
								<ul class="nav">
									<li><a href="{{ url('materials') }}" class="">Material</a></li>
									<li><a href="{{ url('club') }}-material" class="">Club Material</a></li>
								</ul>
							</div>
						</li>
						<li><a href="{{ url('team') }}" class="{{ (request()->segment(1) == 'team') ? 'active' : '' }}"><i class="lnr lnr-linearicons"></i> <span>Team</span></a></li>  
						<li><a href="{{ url('year') }}" class="{{ (request()->segment(1) == 'year') ? 'active' : '' }}"><i class="lnr lnr-text-format"></i> <span>Year</span></a></li>
						@endif
						@if(Auth()->user()->type == 1)
						
						@endif
						<li><a href="{{ url('logout') }}"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
					</ul>
				</nav>
			</div>
		</div>
		</div>
		<!-- END LEFT SIDEBAR -->