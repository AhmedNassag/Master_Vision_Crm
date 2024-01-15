		<!-- Navbar Right Menu -->
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<!-- Messages: style can be found in dropdown.less-->
				@if(LAConfigs::getByKey('show_messages'))
				<li class="dropdown messages-menu">
					<!-- Menu toggle button -->
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-envelope-o"></i>
						<span class="label label-success">4</span>
					</a>
					<ul class="dropdown-menu">
						<li class="header">You have 4 messages</li>
						<li>
							<!-- inner menu: contains the messages -->
							<ul class="menu">
								<li><!-- start message -->
									<a href="#">
										<div class="pull-left">
											<!-- User Image -->
											<img src="{{ asset('la-assets/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image"/>
										</div>
										<!-- Message title and timestamp -->
										<h4>
											Support Team
											<small><i class="fa fa-clock-o"></i> 5 mins</small>
										</h4>
										<!-- The message -->
										<p>Why not buy a new awesome theme?</p>
									</a>
								</li><!-- end message -->
							</ul><!-- /.menu -->
						</li>
						<li class="footer"><a href="#">See All Messages</a></li>
					</ul>
				</li><!-- /.messages-menu -->
				@endif
				@if(LAConfigs::getByKey('show_notifications'))
                                @php
                                if(Auth::user())
                                {
                                	$user=Auth::user();
                                	$notifications = App\Models\Notification::where("employee_id",$user->context_id)->
									orWhere("dept",$user->employee->dept)->
									orWhere(function($q) use($user){
										$q->where("dept",0)->where("employee_id",0);
									})->orderBy("created_at","desc")->get();
                                }
                                @endphp
                                @if(!empty($notifications) && count($notifications)>0)
				<!-- Notifications Menu -->
				<li class="dropdown notifications-menu">
					<!-- Menu toggle button -->
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-bell-o"></i>
						<span class="label label-warning">{{count($notifications)}}</span>
					</a>
					<ul class="dropdown-menu">
						<li class="header">You have {{count($notifications)}} notifications</li>
						<li>
							<!-- Inner Menu: contains the notifications -->
							<ul class="menu">
                                                            @foreach($notifications as $one)
								<li><!-- start notification -->
									<a href="#">
                                                                            <i class="fa fa-users text-aqua"></i> {{$one->notification}}<br>{{$one->created_at->format('j M,Y g:i:s A')}}
									</a>
								</li><!-- end notification -->
                                                            @endforeach
							</ul>
						</li>
						{{--<li class="footer"><a href="#">View all</a></li>--}}
					</ul>
				</li>
				@endif
                                @endif
				@if(LAConfigs::getByKey('show_tasks'))
				<!-- Tasks Menu -->
				<li class="dropdown tasks-menu">
					<!-- Menu Toggle Button -->
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-flag-o"></i>
						<span class="label label-danger">9</span>
					</a>
					<ul class="dropdown-menu">
						<li class="header">You have 9 tasks</li>
						<li>
							<!-- Inner menu: contains the tasks -->
							<ul class="menu">
								<li><!-- Task item -->
									<a href="#">
										<!-- Task title and progress text -->
										<h3>
											Design some buttons
											<small class="pull-right">20%</small>
										</h3>
										<!-- The progress bar -->
										<div class="progress xs">
											<!-- Change the css width attribute to simulate progress -->
											<div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
												<span class="sr-only">20% Complete</span>
											</div>
										</div>
									</a>
								</li><!-- end task item -->
							</ul>
						</li>
						<li class="footer">
							<a href="#">View all tasks</a>
						</li>
					</ul>
				</li>
				@endif
				@if (Auth::guest())
					<li><a href="{{ url('/login') }}">Login</a></li>
					<li><a href="{{ url('/register') }}">Register</a></li>
				@else
					<!-- User Account Menu -->
					<li class="dropdown user user-menu">
						<!-- Menu Toggle Button -->
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<!-- The user image in the navbar-->
							<img src="{{ asset('la-assets/img/user2-160x160.jpg') }}" class="user-image" alt="User Image"/>
							<!-- hidden-xs hides the username on small devices so only the image appears. -->
							<span class="hidden-xs">{{ Auth::user()->name }}</span>
						</a>
						<ul class="dropdown-menu">
							<!-- The user image in the menu -->
							<li class="user-header">
								<img src="{{ asset('la-assets/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image" />
								<p>
									{{ Auth::user()->name }}
									<?php
									$datec = Auth::user()['created_at'];
									?>
									<small>Member since <?php echo date("M. Y", strtotime($datec)); ?></small>
								</p>
							</li>
							<!-- Menu Body -->
							{{-- @if(\Auth::user()->hasRole("SUPER_ADMIN") || \Auth::user()->hasAnyDirectPermission(["SUPER_ADMIN"])) --}}
							@if(\Auth::user()->roles[0]->parent == 0 || \Auth::user()->hasAnyDirectPermission(["SUPER_ADMIN"])) 
							<li class="user-body">
								@if(\Auth::user()->hasAnyDirectPermission(["SUPER_ADMIN"]))
                                                                <div class="col-xs-6 text-center mb10">
									<a href="{{ url(config('laraadmin.adminRoute') . '/modules') }}"><i class="fa fa-cubes"></i> <span>Modules</span></a>
								</div>
								<div class="col-xs-6 text-center mb10">
									<a href="{{ url(config('laraadmin.adminRoute') . '/la_menus') }}"><i class="fa fa-bars"></i> <span>Menus</span></a>
								</div>

								<div class="col-xs-6 text-center mb10">
									<a href="{{ url(config('laraadmin.adminRoute') . '/general_settings') }}"><i class="fa fa-cogs"></i> <span>G. Settings</span></a>
								</div>
                                                                @endif
								@if(\Auth::user()->roles[0]->parent == 0)
								<div class="col-xs-6 text-center mb10">
									<a href="{{ url(config('laraadmin.adminRoute') . '/la_configs') }}"><i class="fa fa-cogs"></i> <span>Configure</span></a>
								</div>
                                                                @endif
							</li>
							@endif
							<!-- Menu Footer-->
							<li class="user-footer">
								<div class="pull-left">
									<a href="{{ url(config('laraadmin.adminRoute') . '/users/') .'/'. Auth::user()->id }}" class="btn btn-default btn-flat">{{ trans('admin.Profile') }}</a>
								</div>
								<div class="pull-right">
									<a href="{{ url('/logout') }}" class="btn btn-default btn-flat">{{ trans('admin.Sign out') }}</a>
								</div>
							</li>
						</ul>
					</li>
				@endif
				@if(LAConfigs::getByKey('show_rightsidebar'))
				<!-- Control Sidebar Toggle Button -->
				<li>
					<a href="#" data-toggle="control-sidebar"><i class="fa fa-comments-o"></i> <span class="label label-warning">10</span></a>
					
				</li>
				@endif
			</ul>
		</div>